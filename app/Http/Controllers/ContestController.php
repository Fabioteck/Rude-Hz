<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestController extends Controller
{
    public function index()
    {
        $contests = Contest::where('is_active', true)->latest()->get();
        return view('contests.index', compact('contests'));
    }

    public function show($slug)
    {
        $contest = Contest::where('slug', $slug)->firstOrFail();
        $userTracks = collect();

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->artist) {
                $userTracks = $user->artist->tracks()->latest()->get();
            }
        }

        return view('contests.show', compact('contest', 'userTracks'));
    }

    /**
     * GESTIONE ISCRIZIONE (Il metodo mancante)
     */
    public function join(Request $request, Contest $contest)
{
    // 1. Validazione
    $request->validate([
        'track_id' => 'required|exists:tracks,id',
        'legal_consent' => 'accepted',
    ], [
        'legal_consent.accepted' => 'Devi accettare il regolamento per procedere.',
    ]);

    $user = auth()->user();
    $trackId = $request->track_id;

    // 2. Controllo proprietà traccia
    $track = \App\Models\Track::where('id', $trackId)->where('user_id', $user->id)->first();
    if (!$track) {
        return back()->with('error', 'Traccia non valida o non trovata nel tuo studio.');
    }

    // 3. Controllo se già iscritta
    if ($contest->tracks()->where('track_id', $trackId)->exists()) {
        return back()->with('error', 'Questa traccia è già iscritta a questo contest.');
    }

    // 4. Controllo limite massimo tracce per artista
    $alreadyJoinedCount = $contest->tracks()
        ->whereHas('artist', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

    if ($alreadyJoinedCount >= $contest->max_tracks_per_artist) {
        return back()->with('error', "Limite raggiunto: max {$contest->max_tracks_per_artist} tracce.");
    }

    // 5. Iscrizione (Rimosso joined_at che non esiste nel DB)
    $contest->tracks()->attach($trackId, [
        'status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return back()->with('success', 'Iscrizione inviata con successo!');
}

}
