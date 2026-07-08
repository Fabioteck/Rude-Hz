<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::latest()->get();
        return view('admin.playlists.index', compact('playlists'));
    }

    public function create()
    {
        $tracks = Track::where('is_approved', true)->with('artist')->get();
        return view('admin.playlists.create', compact('tracks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'tracks' => 'required|array',
        ]);

        $playlist = new Playlist();
        $playlist->title = $request->title;
        $playlist->slug = Str::slug($request->title);
        $playlist->description = $request->description;

        if ($request->hasFile('image')) {
            $playlist->cover_path = $request->file('image')->store('playlists', 'public');
        }

        $playlist->save();
        $playlist->tracks()->sync($request->tracks);

        return redirect()->route('admin.playlists.index')->with('success', 'Playlist creata con successo!');
    }

    public function destroy(Playlist $playlist)
    {
        if ($playlist->cover_path) {
            Storage::disk('public')->delete($playlist->cover_path);
        }
        $playlist->delete();
        return back()->with('warning', 'Playlist eliminata.');
    }
}
