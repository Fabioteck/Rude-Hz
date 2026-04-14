<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Contest;
class PublicContestController extends Controller
{
    public function index()
    {
        $contests = Contest::latest()->get();
        return view('contests.index', compact('contests'));
    }

    public function show($slug)
    {
        $contest = Contest::where('slug', $slug)->firstOrFail();
        return view('contests.show', compact('contest'));
    }

    public function join(Request $request, Contest $contest)
{
    // 1. Validazione stretta
    $validated = $request->validate([
        'track_id'      => 'required|exists:tracks,id',
        'legal_consent' => 'accepted', // Obbligatorio per la liberatoria
    ], [
        'legal_consent.accepted' => 'Devi accettare il regolamento per partecipare.',
        'track_id.exists'        => 'La traccia selezionata non è valida.'
    ]);

    $user = auth()->user();

    // 2. Recupero traccia con controllo di proprietà (evita che qualcuno iscriva tracce altrui)
    $track = $user->tracks()->where('id', $validated['track_id'])->first();

    if (!$track) {
        return back()->with('error', 'Non abbiamo trovato questa traccia nel tuo Studio.');
    }

    // 3. Controllo duplicati sulla tabella pivot
    if ($contest->tracks()->where('track_id', $track->id)->exists()) {
        return back()->with('info', 'Questa traccia è già iscritta a questo contest.');
    }

    try {
        // 4. Inserimento nella pivot con timestamp e stato iniziale
        $contest->tracks()->attach($track->id, [
            'status'     => 'pending',
            'joined_at'  => now(), // Campo utile per cronologia iscrizioni
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Richiesta inviata! La tua traccia è ora in fase di moderazione.');

    } catch (\Exception $e) {
        // Log dell'errore per il debug su RPi
        \Log::error("Errore iscrizione contest {$contest->id}: " . $e->getMessage());
        
        return back()->with('error', 'Si è verificato un problema tecnico. Riprova più tardi.');
    }
}

            

}
