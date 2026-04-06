<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\TrackUploadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Track;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*

|--------------------------------------------------------------------------
| Web Routes - Rude-Hz.it (Professional War Room Edition)
|--------------------------------------------------------------------------
*/

// --- 1. ROTTE PUBBLICHE (FRONT-END) ---
Route::get('/', function () {
    $artists = Artist::all();
    $tracks = Track::where('is_approved', true)->latest()->get();
    return view('welcome', compact('artists', 'tracks'));
})->name('home');

Route::get('/artisti', function () {
    $artists = Artist::latest()->paginate(12);
    return view('artists.index', compact('artists'));
})->name('artists.index');

Route::get('/tracce', function () {
    $tracks = Track::where('is_approved', true)->latest()->paginate(20);
    return view('tracks.index', compact('tracks'));
})->name('tracks.index');

Route::get('/news', function () {
    return view('news.index'); // Qui poi caricheremo le news dal DB
})->name('news.index');


// --- 2. AREA UTENTE / ARTISTA (DASHBOARD & UPLOAD) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestione Account (Standard Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Creazione Profilo Artista
    Route::post('/create-artist', function (Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->name . '-' . rand(100, 999));

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('artists/avatars', 'public');
        }

        Artist::create($data);
        return redirect()->route('dashboard')->with('success', 'Profilo Artistico Creato!');
    })->name('artist.store');

    // Caricamento Tracce
    Route::post('/upload-track', [TrackUploadController::class, 'store'])->name('track.store');
    
    // Edit Traccia Utente (Per cambiare titolo/BPM delle proprie tracce)
    Route::patch('/user/tracks/{track}', function (Request $request, Track $track) {
        if ($track->user_id !== auth()->id()) abort(403);
        $track->update($request->only(['title', 'bpm', 'genre', 'version']));
        return back()->with('success', 'Traccia aggiornata!');
    })->name('user.track.update');

    // Caricamento Tracce
    Route::get('/archivio-tracce', function () {
        // Prendiamo solo quelle approvate che sono attualmente sul player/front-end
        $approvedTracks = \App\Models\Track::where('is_approved', true)->with('artist')->latest()->get();
        return view('admin.tracks-archive', compact('approvedTracks'));
    })->name('admin.tracks.archive');
});


// --- 3. AREA ADMIN (MODERAZIONE, EDIT TOTALE, CANCELLAZIONE) ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard Moderazione (Quella che abbiamo già)
    Route::get('/moderazione', function () {
        $pendingTracks = Track::where('is_approved', false)->with('artist')->latest()->get();
        $allArtists = Artist::withCount('tracks')->get();
        return view('admin.moderation', compact('pendingTracks', 'allArtists'));
    })->name('admin.moderation');

    // APPROVAZIONE
    Route::patch('/approve-track/{track}', function (Track $track) {
        $track->update(['is_approved' => true]);
        return back()->with('success', "Traccia '{$track->title}' pubblicata!");
    })->name('admin.track.approve');

    // CANCELLAZIONE TOTALE (File + DB)
    Route::delete('/delete-track/{track}', function (Track $track) {
        // Eliminiamo i file dal Raspberry per non finire lo spazio
        if ($track->file_path) Storage::disk('public')->delete($track->file_path);
        if ($track->qr_code_path) Storage::disk('public')->delete($track->qr_code_path);
        
        $track->delete();
        return back()->with('success', 'Traccia e file eliminati per sempre.');
    })->name('admin.track.destroy');

    // EDIT ARTISTA (Se l'admin deve correggere bio o social di qualcuno)
    Route::patch('/artist/{artist}', function (Request $request, Artist $artist) {
        $artist->update($request->all());
        return back()->with('success', 'Profilo artista aggiornato dall\'admin.');
    })->name('admin.artist.update');

});

require __DIR__.'/auth.php';
