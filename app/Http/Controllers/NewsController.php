<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Visualizza l'indice delle news (Frontend Pubblico)
     */
    public function index()
    {
        // Prendiamo le news più recenti, paginate per non appesantire il RPi
        $news = News::latest()->paginate(10);
        
        return view('news.index', compact('news'));
    }

    /**
     * Visualizza la singola news tramite Slug
     */
    public function show($slug)
    {
        // Cerchiamo la news per slug, se non esiste 404
        $news = News::where('slug', $slug)->firstOrFail();

        // Prendiamo altre news correlate (le ultime 3 escludendo quella corrente)
        $relatedNews = News::where('id', '!=', $news->id)
                           ->latest()
                           ->take(3)
                           ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }
}
