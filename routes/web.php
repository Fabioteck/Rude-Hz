<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\{Track, Artist, News, Contest};
use App\Http\Controllers\{WelcomeController, ProfileController, PlaylistController};
use App\Http\Controllers\Admin\{RadioController, NewsController as AdminNewsController, NewsCategoryController, PlaylistController as AdminPlaylistController, ContestController as AdminContestController, ArtistController as AdminArtistController};
use App\Http\Controllers\PublicTrackController;
// API per Analytics JS (Aggiornata con incremento tempo di permanenza)
Route::post('/api/analytics/metadata', function (\Illuminate\Http\Request $request) {
    // Recuperiamo l'ID specifico passato dal JS o l'ultimo record come fallback
    $analyticId = $request->input('analytics_id') ?? session('last_analytics_id');
    
    $analytic = $analyticId 
        ? \App\Models\Analytic::find($analyticId) 
        : \App\Models\Analytic::latest()->first();

    if ($analytic) {
        // Prepariamo i dati da aggiornare se presenti nella richiesta
        $updateData = [];
        if ($request->has('screen_resolution')) $updateData['screen_resolution'] = $request->screen_resolution;
        if ($request->has('connection_type')) $updateData['connection_type'] = $request->connection_type;

        if (!empty($updateData)) {
            $analytic->update($updateData);
        }

        // Incremento dei secondi di permanenza inviati dal timer frontend
        $seconds = (int) ($request->input('seconds') ?? 15);
        $analytic->increment('duration', $seconds);
    }

    return response()->json(['status' => 'success']);
});

/* --- 1. AREA PUBBLICA --- */
Route::get('/track/{slug}', [WelcomeController::class, 'showTrack'])->name('track.public.show');
Route::get('/', function () {
    $tracks = Track::active()->where('is_approved', true)->with('artist')->latest()->get();
    $artists = Artist::active()->latest()->get();
    $latestNews = News::where('is_published', true)->latest()->first();
    $otherNews = News::where('is_published', true)->latest()->skip(1)->take(5)->get();
    return view('welcome', compact('tracks', 'artists', 'latestNews', 'otherNews'));
})->name('home');

Route::get('/tracks', [PublicTrackController::class, 'index'])->name('tracks.index');
Route::get('/tracks/{track}/stream', [PublicTrackController::class, 'stream'])->name('tracks.stream');
Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

// Playlist Pubbliche
Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
Route::get('/playlist', function () { return redirect()->route('playlists.index', [], 301); });
Route::get('/playlists/{slug}', [PlaylistController::class, 'show'])->name('playlists.show');

Route::get('/project', function () { return view('project'); })->name('project');
Route::get('/support', function () { return view('support'); })->name('support');
Route::get('/manifest.json', function () {
    return response()->json(json_decode(file_get_contents(public_path('manifest.json')), true));
});
Route::get('/sw.js', function () {
    return response(file_get_contents(public_path('sw.js')), 200, ['Content-Type' => 'application/javascript']);
});
Route::get('/lang/{locale}', function ($locale) {
    $supported = ['it', 'en', 'es'];
    if (in_array($locale, $supported)) {
        session(['locale' => $locale]);
        cookie()->queue(cookie()->forever('locale', $locale));
    }
    return redirect()->back(fallback: route('home'));
})->name('lang.switch');
Route::get('/artists', [\App\Http\Controllers\ArtistController::class, 'publicIndex'])->name('artists.index');
Route::get('/artists/{artist:slug}', [\App\Http\Controllers\ArtistController::class, 'show'])->name('artists.show');
Route::get('/contests', [\App\Http\Controllers\ContestController::class, 'index'])->name('contests.index');
Route::get('/contests/{slug}', [\App\Http\Controllers\ContestController::class, 'show'])->name('contests.show');

/* --- 2. AREA PRIVATA --- */
Route::middleware(['auth'])->group(function () {
    
    // Rotta di test premium (fondamenta piano pro)
    Route::middleware(['plan:pro'])->get('/test-premium', function () {
        return response()->json(['status' => 'success', 'message' => 'Welcome to Pro Plan']);
    })->name('test.premium');
    
    // Console Utente
    Route::get('/console', function () {
        $user = auth()->user();
        $tracks = Track::where('user_id', $user->id)->latest()->get();
        return view('user.console', compact('user', 'tracks'));
    })->name('user.console');

    // Manuali Console (MVP)
    Route::get('/console/manuals', [\App\Http\Controllers\User\ManualController::class, 'index'])->name('user.manuals.index');
    Route::get('/console/manuals/{manual:slug}', [\App\Http\Controllers\User\ManualController::class, 'show'])->name('user.manuals.show');

    // Assistant Console
    Route::get('/console/assistant', [\App\Http\Controllers\User\AssistantController::class, 'index'])->name('user.assistant');
    Route::post('/console/assistant/send', [\App\Http\Controllers\User\AssistantController::class, 'send'])->name('user.assistant.send');

    // Switcher Dashboard
    Route::get('/dashboard', function () {
        return auth()->user()->is_admin ? redirect()->route('admin.dashboard') : redirect()->route('user.studio');
    })->name('dashboard');

    // Logout
    Route::get('/exit', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout.get');

    // Profilo
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // My Studio
    Route::middleware(['can:user-only'])->prefix('my-studio')->group(function () {
        Route::get('/', function () {
            $user = auth()->user();
            $artist = Artist::firstOrCreate(['user_id' => $user->id], ['name' => $user->name, 'slug' => Str::slug($user->name . '-' . $user->id), 'style' => 'default']);
            $tracks = Track::where('user_id', $user->id)->latest()->get();
            return view('user.studio', compact('tracks', 'artist', 'user'));
        })->name('user.studio');

        Route::get('/tracks', [\App\Http\Controllers\User\TrackUploadController::class, 'index'])->name('user.tracks.index');
        Route::post('/upload-track', [\App\Http\Controllers\User\TrackUploadController::class, 'store'])->name('track.store');
        Route::post('/tracks/{track}/update', [\App\Http\Controllers\User\TrackUploadController::class, 'update'])->name('user.track.update');
        Route::delete('/tracks/{track}', [\App\Http\Controllers\User\TrackUploadController::class, 'destroy'])->name('user.track.destroy');
        Route::get('/tracks/{track}/edit', [App\Http\Controllers\User\TrackUploadController::class, 'edit'])->name('user.track.edit');
        Route::post('/update-artist', [\App\Http\Controllers\ArtistController::class, 'updateArtist'])->name('user.update.artist');
        Route::post('/contests/{contest}/join', [\App\Http\Controllers\ContestController::class, 'join'])->name('contests.join');
    });

    // LIBERATORIA
    Route::get('/liberatoria', [ProfileController::class, 'editLiberatoria'])->name('profile.liberatoria');
    Route::post('/liberatoria', [ProfileController::class, 'updateLiberatoria'])->name('profile.liberatoria.update');

    /* --- CONSOLE ADMIN --- */
    Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/', [RadioController::class, 'index'])->name('dashboard');
        
        // GESTIONE RADIO
        Route::prefix('radio')->name('radio.')->group(function () {
            Route::get('/archive', [RadioController::class, 'archive'])->name('archive');
            Route::patch('/approve/{track}', [RadioController::class, 'toggleApprove'])->name('approve');
            Route::patch('/tracks/{track}/toggle-active', [RadioController::class, 'toggleActive'])->name('tracks.toggle-active');
            Route::delete('/destroy/{track}', [RadioController::class, 'destroy'])->name('destroy');
        });

        // Risorse Admin
        Route::resource('news', AdminNewsController::class);
        Route::resource('news-categories', NewsCategoryController::class)->only(['store', 'destroy']);
        Route::resource('playlists', AdminPlaylistController::class);
        Route::resource('contests', AdminContestController::class);
        Route::patch('/artists/{artist}/toggle-active', [AdminArtistController::class, 'toggleActive'])->name('artists.toggle-active');
        Route::resource('artists', AdminArtistController::class)->parameters(['artists' => 'artist']);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::patch('/users/{user}/toggle-active', [\App\Http\Controllers\Admin\UserController::class, 'toggleActive'])->name('users.toggle-active');
        
        // Statistiche
        Route::get('/stats', [\App\Http\Controllers\Admin\AdminStatisticController::class, 'index'])->name('stats.index');
        
        // Upload PDF Manuali (Admin RAG)
        Route::get('/manuals/upload', [\App\Http\Controllers\Admin\ManualUploadController::class, 'create'])->name('manuals.upload');
        Route::post('/manuals/upload', [\App\Http\Controllers\Admin\ManualUploadController::class, 'store'])->name('manuals.upload.store');

        // Monitoraggio
        Route::get('/system-stats', [RadioController::class, 'getSystemStats'])->name('stats');
        Route::patch('/contests/{contest}/tracks/{track}/status', [AdminContestController::class, 'updateTrackStatus'])->name('contests.update-status');
    });
});

require __DIR__.'/auth.php';
