<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function index()
    {
        StaticPage::firstOrCreate(
            ['slug' => 'project'],
            [
                'title' => 'Project',
                'subtitle' => 'Il manifesto underground & la filosofia della community',
                'content' => 'Questa è una community nata anni orsono dall\'esigenza di piccoli producer di province diverse e lontane...'
            ]
        );

        StaticPage::firstOrCreate(
            ['slug' => 'support'],
            [
                'title' => 'Supporta Rude-Hz',
                'subtitle' => 'Sostieni il progetto indipendente Rude-Hz',
                'content' => 'Sostieni il progetto indipendente Rude-Hz. Scopri come contribuire alla crescita della community underground senza pubblicità.'
            ]
        );

        $pages = StaticPage::all();
        return view('admin.pages.index', compact('pages'));
    }

    public function edit(StaticPage $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, StaticPage $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Pagina statica aggiornata con successo!');
    }
}
