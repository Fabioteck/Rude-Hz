<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::orderBy('name', 'asc')->paginate(20);
        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        return view('admin.artists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $artist = new Artist();
        $this->mapArtistData($artist, $request);
        
        // Assegnazione user_id solo in creazione
        $artist->user_id = $request->user_id;
        $artist->save();

        return redirect()->route('admin.artists.index')->with('success', 'Artista creato con successo!');
    }

    public function edit(Artist $artist)
    {
        // Rimosso l'abort(403) manuale: l'autorizzazione è gestita dal middleware delle rotte
        return view('admin.artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->mapArtistData($artist, $request);
        $artist->save();

        return redirect()->route('admin.artists.index')->with('success', 'Profilo aggiornato.');
    }

    /**
     * Helper per mappare i dati ed evitare ripetizioni (DRY)
     */
    private function mapArtistData(Artist $artist, Request $request)
    {
        $artist->name = $request->name;
        $artist->slug = Str::slug($request->name);
        $artist->bio = $request->bio;
        $artist->style = $request->style;
        $artist->nostr_npub = $request->nostr_npub;
        $artist->ln_address = $request->ln_address;
        $artist->apple_music_url = $request->apple_music_url;
        $artist->spotify_url = $request->spotify_url;
        $artist->soundcloud_url = $request->soundcloud_url;
        $artist->instagram_url = $request->instagram_url;
        $artist->youtube_url = $request->youtube_url;
        $artist->facebook_url = $request->facebook_url;

        // Gestione Profile Image
        if ($request->hasFile('profile_image')) {
            if ($artist->profile_image) Storage::disk('public')->delete($artist->profile_image);
            $artist->profile_image = $request->file('profile_image')->store('artists/avatars', 'public');
        }

        // Gestione Photo/Cover
        if ($request->hasFile('photo')) {
            if ($artist->photo) Storage::disk('public')->delete($artist->photo);
            $artist->photo = $request->file('photo')->store('artists/covers', 'public');
        }
    }

    public function destroy(Artist $artist)
    {
        if ($artist->profile_image) Storage::disk('public')->delete($artist->profile_image);
        if ($artist->photo) Storage::disk('public')->delete($artist->photo);
        $artist->delete();
        
        return redirect()->route('admin.artists.index')->with('warning', 'Artista rimosso.');
    }
}
