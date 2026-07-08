<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;

class PublicTrackController extends Controller
{
    public function index()
    {
        $tracks = Track::where('is_approved', true)->with('artist')->latest()->get();
        return view('tracks', compact('tracks'));
    }

    public function stream(\App\Models\Track $track)
    {
        $path = storage_path('app/' . $track->file_path);
        
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'audio/mpeg',
            'Accept-Ranges' => 'bytes',
        ]);
    }
}
