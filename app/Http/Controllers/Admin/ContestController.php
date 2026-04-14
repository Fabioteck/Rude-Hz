<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContestController extends Controller
{
    public function index()
    {
        // Recupera i contest con il conteggio delle tracce per la tabella
        $contests = Contest::withCount('tracks')->latest()->paginate(10);
        return view('admin.contests.index', compact('contests'));
    }

    public function create()
    {
        return view('admin.contests.create');
    }

    public function store(Request $request)
    {

         // dd($request->all()); 
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'legal_disclaimer' => 'required',
            'max_tracks_per_artist' => 'required|integer|min:1',
            'playlist_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'rules_pdf' => 'nullable|mimes:pdf|max:5120',
        ]);

        // Creazione istanza e popolamento tramite fillable
        $contest = new Contest();
        $contest->fill($validated);
        
        // Campi gestiti manualmente
        $contest->slug = Str::slug($request->title);
        $contest->is_active = true; // Di default attivo alla creazione

        // Gestione Immagine
        if ($request->hasFile('image')) {
            $contest->image_path = $request->file('image')->store('contests/images', 'public');
        }

        // Gestione PDF
        if ($request->hasFile('rules_pdf')) {
            $contest->rules_pdf = $request->file('rules_pdf')->store('contests/docs', 'public');
        }

        $contest->save();

        return redirect()->route('admin.contests.index')->with('success', 'Contest creato con successo.');
    }

    public function edit(Contest $contest)
    {
        return view('admin.contests.edit', compact('contest'));
    }

    public function update(Request $request, Contest $contest)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'legal_disclaimer' => 'required',
            'max_tracks_per_artist' => 'required|integer|min:1',
            'playlist_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'rules_pdf' => 'nullable|mimes:pdf|max:5120',
        ]);

        // Aggiorna i campi fillable
        $contest->fill($validated);
        $contest->slug = Str::slug($request->title);
        
        // Gestione checkbox is_active (se non spuntata non arriva nel request)
        $contest->is_active = $request->has('is_active');

        // Aggiornamento Immagine (elimina la vecchia se presente)
        if ($request->hasFile('image')) {
            if ($contest->image_path) {
                Storage::disk('public')->delete($contest->image_path);
            }
            $contest->image_path = $request->file('image')->store('contests/images', 'public');
        }

        // Aggiornamento PDF (elimina il vecchio se presente)
        if ($request->hasFile('rules_pdf')) {
            if ($contest->rules_pdf) {
                Storage::disk('public')->delete($contest->rules_pdf);
            }
            $contest->rules_pdf = $request->file('rules_pdf')->store('contests/docs', 'public');
        }

        $contest->save();

        return redirect()->route('admin.contests.index')->with('success', 'Contest aggiornato con successo.');
    }

    public function destroy(Contest $contest)
    {
        // Pulizia file fisici dallo storage dell'RPi 4
        if ($contest->image_path) {
            Storage::disk('public')->delete($contest->image_path);
        }
        if ($contest->rules_pdf) {
            Storage::disk('public')->delete($contest->rules_pdf);
        }
        
        $contest->delete();

        return redirect()->route('admin.contests.index')->with('success', 'Contest eliminato definitivamente.');
    }
}
