<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $news = News::with('category')
            ->when($search, function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('subtitle', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $categories = \App\Models\NewsCategory::all();
        return view('admin.news.index', compact('news', 'categories', 'search'));
    }

    public function create()
    {
        $categories = \App\Models\NewsCategory::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validazione
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'image' => 'required|image|max:2048', // Max 2MB
            'content' => 'required',
        ]);

        // 2. Creazione news
        $news = new News();
        $news->title = $request->title;
        $news->subtitle = $request->subtitle;
        $news->category_id = $request->category_id;
        $news->slug = Str::slug($request->title);
        $news->content = $request->content;
        $news->is_published = $request->has('is_published');
        $news->user_id = auth()->id(); 

        // 3. Gestione Immagine
        if ($request->hasFile('image')) {
            $news->image_path = \App\Services\ImageOptimizerService::optimizeAndStore($request->file('image'), 'news', 1200);
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'News pubblicata!');
    }

    public function edit(News $news)
    {
        $categories = \App\Models\NewsCategory::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        // Validazione per l'aggiornamento
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'image' => 'nullable|image|max:2048',
            'content' => 'required',
        ]);

        $news->title = $request->title;
        $news->subtitle = $request->subtitle;
        $news->category_id = $request->category_id;
        $news->slug = Str::slug($request->title);
        $news->content = $request->content;
        $news->is_published = $request->has('is_published');

        if ($request->hasFile('image')) {
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $news->image_path = \App\Services\ImageOptimizerService::optimizeAndStore($request->file('image'), 'news', 1200);
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
