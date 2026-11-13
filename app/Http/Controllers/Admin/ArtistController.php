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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $artists = Artist::when($search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('style', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.artists.index', compact('artists', 'search'));
    }

    public function toggleActive(Artist $artist)
    {
        $artist->is_active = !$artist->is_active;
        $artist->save();

        return response()->json([
            'success' => true,
            'is_active' => $artist->is_active
        ]);
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
        $artist->is_active = $request->has('is_active');

        // Gestione Profile Image
        if ($request->hasFile('profile_image')) {
            if ($artist->profile_image) Storage::disk('public')->delete($artist->profile_image);
            $artist->profile_image = \App\Services\ImageOptimizerService::optimizeAndStore($request->file('profile_image'), 'artists/avatars', 400);
        }

        // Gestione Photo/Cover
        if ($request->hasFile('photo')) {
            if ($artist->photo) Storage::disk('public')->delete($artist->photo);
            $artist->photo = \App\Services\ImageOptimizerService::optimizeAndStore($request->file('photo'), 'artists/covers', 1200);
        }
    }

    public function destroy(Artist $artist)
    {
        if ($artist->profile_image) Storage::disk('public')->delete($artist->profile_image);
        if ($artist->photo) Storage::disk('public')->delete($artist->photo);

        foreach ($artist->tracks as $track) {
            if ($track->file_path) Storage::disk('public')->delete($track->file_path);
            if ($track->cover_path) Storage::disk('public')->delete($track->cover_path);
            $track->delete();
        }

        if ($artist->user) {
            $artist->user->update([
                'role' => 'listener',
                'is_admin' => false,
            ]);
        }

        $artist->delete();
        
        return redirect()->route('admin.artists.index')->with('success', 'Artista e relative tracce eliminati. Account mantenuto come ascoltatore.');
    }
}
