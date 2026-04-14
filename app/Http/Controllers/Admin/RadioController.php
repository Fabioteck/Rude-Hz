<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RadioController extends Controller
{
    /**
     * Dashboard Radio: Riepilogo statistiche e coda rapida.
     */
    public function index()
    {
        $pendingTracksCount = Track::where('is_approved', false)->count();
        $totalTracks = Track::count();
        $approvedTracksCount = Track::where('is_approved', true)->count();

        // Carica i pendenti per la tabella rapida in Dashboard
        $pendingTracks = Track::with('user')
            ->where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.radio.index', compact(
            'pendingTracks', 
            'pendingTracksCount', 
            'totalTracks', 
            'approvedTracksCount'
        ));
    }

    /**
     * Visualizza la coda di moderazione specifica.
     */
    public function moderation()
    {
        $pendingTracks = Track::with('user')
            ->where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.radio.moderation', compact('pendingTracks'));
    }

    /**
     * Visualizza l'archivio completo di tutte le tracce.
     */
    public function archive()
    {
        $tracks = Track::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('admin.radio.tracks-archive', compact('tracks'));
    }

    /**
     * Approva o mette in pausa una traccia.
     */
    public function toggleApprove(Track $track)
    {
        $newState = !$track->is_approved;

        $track->update([
            'is_approved' => $newState,
            'approved_at' => $newState ? now() : null,
        ]);

        $message = $newState ? 'Traccia approvata e messa in onda!' : 'Traccia rimossa dalla rotazione.';
        
        return back()->with('success', $message);
    }

    /**
     * Elimina definitivamente file (da storage/RPi) e record DB.
     */
    public function destroy(Track $track)
    {
        if ($track->file_path && Storage::disk('public')->exists($track->file_path)) {
            Storage::disk('public')->delete($track->file_path);
        }

        $track->delete();

        return back()->with('warning', 'Traccia eliminata definitivamente.');
    }
}
