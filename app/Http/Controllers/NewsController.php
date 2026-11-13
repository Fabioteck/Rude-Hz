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
        // Prendiamo le news più recenti pubblicate, paginate per non appesantire il RPi
        $news = News::where('is_published', true)->latest()->paginate(10);
        
        return view('news.index', compact('news'));
    }

    /**
     * Visualizza la singola news tramite Slug
     */
    public function show($slug)
    {
        // Cerchiamo la news pubblicata per slug, se non esiste 404
        $news = News::where('slug', $slug)->where('is_published', true)->firstOrFail();

        // Prendiamo altre news correlate pubblicate (le ultime 3 escludendo quella corrente)
        $relatedNews = News::where('id', '!=', $news->id)
                           ->where('is_published', true)
                           ->latest()
                           ->take(3)
                           ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }
}
