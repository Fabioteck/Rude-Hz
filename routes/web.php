<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\{Track, Artist, News, Contest};
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;

/* --- 1. AREA PUBBLICA --- */
Route::get('/track/{slug}', [WelcomeController::class, 'showTrack'])->name('track.public.show');

Route::get('/', function () {
    $tracks = Track::where('is_approved', true)->with('artist')->latest()->get();
    $artists = Artist::latest()->get();
    $latestNews = News::latest()->first();
    $otherNews = News::latest()->skip(1)->take(5)->get();
    return view('welcome', compact('tracks', 'artists', 'latestNews', 'otherNews'));
})->name('home');

Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
Route::get('/artists/{artist:slug}', [\App\Http\Controllers\ArtistController::class, 'show'])->name('artists.show');
Route::get('/contests', [\App\Http\Controllers\ContestController::class, 'index'])->name('contests.index');
Route::get('/contests/{slug}', [\App\Http\Controllers\ContestController::class, 'show'])->name('contests.show');

/* --- 2. AREA PRIVATA --- */
Route::middleware(['auth'])->group(function () {
    
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

    // Profilo Breeze
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    /* --- MY STUDIO (ARTISTA) --- */
    Route::middleware(['can:user-only'])->prefix('my-studio')->group(function () {
        
        Route::get('/', function () {
            $user = auth()->user();
            $artist = Artist::firstOrCreate(
                ['user_id' => $user->id], 
                ['name' => $user->name, 'slug' => Str::slug($user->name . '-' . $user->id), 'style' => 'default']
            );
            $tracks = Track::where('user_id', $user->id)->latest()->get();
            return view('user.studio', compact('tracks', 'artist', 'user'));
        })->name('user.studio');

        Route::get('/tracks', [\App\Http\Controllers\User\TrackUploadController::class, 'index'])->name('user.tracks.index');
        Route::post('/upload-track', [\App\Http\Controllers\User\TrackUploadController::class, 'store'])->name('track.store');
        Route::patch('/tracks/{track}', [\App\Http\Controllers\User\TrackUploadController::class, 'update'])->name('user.track.update');
        Route::delete('/tracks/{track}', [\App\Http\Controllers\User\TrackUploadController::class, 'destroy'])->name('user.track.destroy');
        Route::get('/tracks/{track}/edit', [App\Http\Controllers\User\TrackUploadController::class, 'edit'])->name('user.track.edit');
        
        Route::post('/update-artist', [\App\Http\Controllers\ArtistController::class, 'updateArtist'])->name('user.update.artist');
        Route::post('/contests/{contest}/join', [\App\Http\Controllers\ContestController::class, 'join'])->name('contests.join');
    });

    // LIBERATORIA
    Route::middleware(['auth'])->group(function () {
        Route::get('/liberatoria', [ProfileController::class, 'editLiberatoria'])->name('profile.liberatoria');
        Route::post('/liberatoria', [ProfileController::class, 'updateLiberatoria'])->name('profile.liberatoria.update');
    });

    /* --- CONSOLE ADMIN --- */
    Route::middleware(['can:admin-only'])->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/', [\App\Http\Controllers\Admin\RadioController::class, 'index'])->name('dashboard');
        
        // GESTIONE RADIO (CENTRALE)
        Route::prefix('radio')->name('radio.')->group(function () {
            // Archivio Unificato (Include la logica di Moderazione)
            Route::get('/archive', [\App\Http\Controllers\Admin\RadioController::class, 'archive'])->name('archive');
            Route::patch('/approve/{track}', [\App\Http\Controllers\Admin\RadioController::class, 'toggleApprove'])->name('approve');
            Route::delete('/destroy/{track}', [\App\Http\Controllers\Admin\RadioController::class, 'destroy'])->name('destroy');

            // Nuova Sezione Playlist per Player MP3
            Route::get('/playlist', [\App\Http\Controllers\Admin\RadioController::class, 'playlist'])->name('playlist');
            Route::post('/playlist/update', [\App\Http\Controllers\Admin\RadioController::class, 'updatePlaylist'])->name('playlist.update');
        });

        // Risorse Admin
        Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
        Route::resource('contests', \App\Http\Controllers\Admin\ContestController::class);
        Route::resource('artists', \App\Http\Controllers\Admin\ArtistController::class)->parameters(['artists' => 'artist']);
        
        // Moderazione Contest
        Route::get('/contests/{contest}/participants', [\App\Http\Controllers\Admin\ContestController::class, 'participants'])->name('contests.participants');
        Route::patch('/contests/{contest}/tracks/{track}/status', [\App\Http\Controllers\Admin\ContestController::class, 'updateTrackStatus'])->name('contests.update-status');
    });
});

require __DIR__.'/auth.php';
