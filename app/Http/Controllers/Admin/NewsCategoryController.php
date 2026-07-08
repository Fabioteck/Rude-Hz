<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:news_categories,name']);
        
        NewsCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Categoria creata.');
    }

    public function destroy(NewsCategory $category)
    {
        $category->delete();
        return back()->with('warning', 'Categoria eliminata.');
    }
}
