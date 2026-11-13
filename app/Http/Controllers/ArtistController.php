<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    public function publicIndex()
    {
        $artists = \App\Models\Artist::active()->orderBy('name', 'asc')->paginate(20);
        // CORREZIONE PERCORSO: 'artist.index' invece di 'artists.index'
        return view('artist.index', compact('artists'));
    }

    /**
     * Mostra il profilo del singolo artista con le sue tracce approvate.
     */
    public function show($slug)
    {
        $artist = \App\Models\Artist::active()->where('slug', $slug)->firstOrFail();
        
        // Eager loading delle tracce approvate per l'artista selezionato
        $tracks = $artist->tracks()->active()->where('is_approved', true)->latest()->get();

        // CORREZIONE PERCORSO: 'artist.show' invece di 'artists.show'
        return view('artist.show', compact('artist', 'tracks'));
    }

    public function updateArtist(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        $artist = Artist::where('user_id', Auth::id())->firstOrFail();

        // 1. Salvataggio testi (Bio, Social, Style)
        $artist->fill($request->except(['_token', 'photo', 'profile_image']));

        $statusMessage = "Dati salvati. ";

        // 2. GESTIONE AVATAR (profile_image)
        if ($request->hasFile('profile_image')) {
            // Pulizia vecchia immagine
            if ($artist->profile_image) {
                Storage::disk('public')->delete($artist->profile_image);
            }
            // Salvataggio ottimizzato WebP
            $path = \App\Services\ImageOptimizerService::optimizeAndStore($request->file('profile_image'), 'artists/avatars', 400);
            $artist->profile_image = $path;
            $statusMessage .= "Avatar caricato! ";
        }

        // 3. GESTIONE COVER (photo)
        if ($request->hasFile('photo')) {
            if ($artist->photo) {
                Storage::disk('public')->delete($artist->photo);
            }
            $path = \App\Services\ImageOptimizerService::optimizeAndStore($request->file('photo'), 'artists/covers', 1200);
            $artist->photo = $path;
            $statusMessage .= "Cover caricata! ";
        }

        // 4. SCRITTURA FINALE DB
        $artist->save();

        return back()->with('success', $statusMessage);
    }
}
