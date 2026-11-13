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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $playlists = Playlist::when($search, function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.playlists.index', compact('playlists', 'search'));
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
            $playlist->cover_path = \App\Services\ImageOptimizerService::optimizeAndStore($request->file('image'), 'playlists', 800);
        }

        $playlist->save();
        $playlist->tracks()->sync($request->tracks);

        return redirect()->route('admin.playlists.index')->with('success', 'Playlist creata con successo!');
    }

    public function edit(Playlist $playlist)
    {
        $tracks = Track::where('is_approved', true)->with('artist')->get();
        return view('admin.playlists.edit', compact('playlist', 'tracks'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'tracks' => 'required|array',
        ]);

        $playlist->title = $request->title;
        $playlist->slug = Str::slug($request->title);
        $playlist->description = $request->description;

        if ($request->hasFile('image')) {
            if ($playlist->cover_path) {
                Storage::disk('public')->delete($playlist->cover_path);
            }
            $playlist->cover_path = \App\Services\ImageOptimizerService::optimizeAndStore($request->file('image'), 'playlists', 800);
        }

        $playlist->save();
        $playlist->tracks()->sync($request->tracks);

        return redirect()->route('admin.playlists.index')->with('success', 'Playlist aggiornata con successo!');
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
