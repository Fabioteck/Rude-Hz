<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        // 1. Validazione (Le regole sono fondamentali per non far crashare Laravel)
        $request->validate([]);

        // 2. Creazione news
        $news = new News();
        $news->title = $request->title;
        $news->slug = Str::slug($request->title);
        $news->content = $request->content;
        $news->is_published = $request->has('is_published');
        
        // 3. User ID obbligatorio (Evita l'errore SQL Integrity constraint violation)
        $news->user_id = auth()->id(); 

        // 4. Gestione Immagine
        if ($request->hasFile('image')) {
            $news->image_path = $request->file('image')->store('news', 'public');
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'News pubblicata!');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        // Validazione anche per l'aggiornamento
        $request->validate([]);

        $news->title = $request->title;
        $news->slug = Str::slug($request->title);
        $news->content = $request->content;
        $news->is_published = $request->has('is_published');

        if ($request->hasFile('image')) {
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $news->image_path = $request->file('image')->store('news', 'public');
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'News aggiornata correttamente.');
    }

    public function destroy(News $news)
    {
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('warning', 'News eliminata.');
    }
}
