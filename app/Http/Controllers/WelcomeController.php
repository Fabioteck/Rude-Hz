<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Track;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Visualizza la Home Page (Welcome)
     */
    public function index()
    {
        $artists = Artist::latest()->take(4)->get();
        $tracks = Track::with('artist')->latest()->take(5)->get();
        
        return view('welcome', compact('artists', 'tracks'));
    }

    /**
     * Visualizza la pagina pubblica della singola traccia (quella del QR)
     */
    public function showTrack($slug)
    {
        // Recuperiamo la traccia tramite lo slug caricando anche i dati dell'artista
        // Usiamo firstOrFail così se lo slug è sbagliato spara una 404 automatica
        $track = Track::where('slug', $slug)->with('artist')->firstOrFail();

        // Mappato sulla tua struttura: resources/views/user/tracks/show.blade.php
        return view('user.tracks.show', compact('track'));
    }
}
