<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Manual;
use Illuminate\Http\Request;

class ManualController extends Controller
{
    public function index(Request $request)
    {
        $query = Manual::where('is_published', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $manuals = $query->latest()->get();
        $categories = Manual::where('is_published', true)->distinct()->pluck('category');
        $levels = Manual::where('is_published', true)->distinct()->pluck('level');

        return view('user.manuals.index', compact('manuals', 'categories', 'levels'));
    }

    public function show(Manual $manual)
    {
        abort_unless($manual->is_published, 404);
        return view('user.manuals.show', compact('manual'));
    }
}
