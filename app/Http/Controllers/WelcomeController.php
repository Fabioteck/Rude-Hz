<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
{
    $artists = \App\Models\Artist::latest()->take(4)->get();
    $tracks = \App\Models\Track::with('artist')->latest()->take(5)->get();
    
    return view('welcome', compact('artists', 'tracks'));
}
}

