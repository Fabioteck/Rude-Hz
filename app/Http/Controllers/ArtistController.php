<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    public function show($slug)
    {
        $artist = Artist::where('slug', $slug)->firstOrFail();
        $tracks = $artist->tracks()->where('is_approved', true)->get();
        return view('artists.show', compact('artist', 'tracks'));
    }

    public function updateArtist(Request $request)
    {
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
            // Salvataggio fisico
            $path = $request->file('profile_image')->store('artists/avatars', 'public');
            $artist->profile_image = $path;
            $statusMessage .= "Avatar caricato! ";
        }

        // 3. GESTIONE COVER (photo)
        if ($request->hasFile('photo')) {
            if ($artist->photo) {
                Storage::disk('public')->delete($artist->photo);
            }
            $path = $request->file('photo')->store('artists/covers', 'public');
            $artist->photo = $path;
            $statusMessage .= "Cover caricata! ";
        }

        // 4. SCRITTURA FINALE DB
        $artist->save();

        return back()->with('success', $statusMessage);
    }
}
