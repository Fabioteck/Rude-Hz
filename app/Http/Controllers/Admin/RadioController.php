<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RadioController extends Controller
{
    /**
     * MONITORAGGIO HARDWARE (Raspberry Pi)
     */
    public function getSystemStats()
    {
        // Temperatura
        $temp = shell_exec('cat /sys/class/thermal/thermal_zone0/temp');
        $tempCelsius = ($temp !== null) ? round($temp / 1000, 1) . '°C' : 'N/A';

        // Carico (Load Average - 1 minuto)
        $load = sys_getloadavg();
        $loadPercentage = ($load !== false) ? round($load[0] * 10, 0) . '%' : 'N/A';

        return response()->json([
            'temp' => $tempCelsius,
            'load' => $loadPercentage
        ]);
    }

    /**
     * Dashboard Generale Admin
     */
    public function index()
    {
        // Nota: Assicurati che il percorso del file sia corretto (solitamente admin.dashboard)
        return view('admin.dashboard'); 
    }

    /**
     * ARCHIVIO UNIFICATO (Moderazione + Gestione Generale)
     * Carica tutte le tracce indipendentemente dallo stato.
     */
    public function archive()
    {
        $tracks = Track::with('artist')->latest()->get();
        return view('admin.radio.archive', compact('tracks'));
    }

    /**
     * SELEZIONE PLAYLIST OPERATIVA
     * Mostra solo le tracce che hanno superato la moderazione (is_approved = true).
     */
    public function playlist()
    {
        $approvedTracks = Track::where('is_approved', true)
                                ->with('artist')
                                ->orderBy('title', 'asc')
                                ->get();

        return view('admin.radio.playlist', compact('approvedTracks'));
    }

    /**
     * SALVATAGGIO PLAYLIST & GENERAZIONE JSON PER RASPBERRY
     */
    public function updatePlaylist(Request $request)
    {
        // 1. Reset: Nessuna traccia è in playlist
        Track::query()->update(['in_playlist' => false]);

        // 2. Attivazione tracce selezionate
        if ($request->has('playlist')) {
            Track::whereIn('id', $request->playlist)
                 ->update(['in_playlist' => true]);
        }

        // 3. Sincronizzazione File JSON per il Player MP3
        $this->syncRaspberryPlaylist();

        return back()->with('success', 'Playlist aggiornata e file JSON generato per il Raspberry!');
    }

    /**
     * TOGGLE APPROVAZIONE (Moderazione rapida dall'archivio)
     */
    public function toggleApprove(Track $track)
    {
        $track->update([
            'is_approved' => !$track->is_approved
        ]);

        // Se rimuovo l'approvazione, la tolgo automaticamente anche dalla playlist operativa
        if (!$track->is_approved) {
            $track->update(['in_playlist' => false]);
            $this->syncRaspberryPlaylist();
        }

        $status = $track->is_approved ? 'Approvata' : 'Spostata in Coda';
        return back()->with('success', "Traccia $status con successo.");
    }

    /**
     * ELIMINAZIONE TRACCIA
     */
    public function destroy(Track $track)
    {
        // 1. Cancellazione FISICA dei file (Audio e Cover)
        if ($track->track_path) {
            Storage::disk('public')->delete($track->track_path);
        }
        if ($track->cover_path) {
            Storage::disk('public')->delete($track->cover_path);
        }
        
        // 2. Soft Delete del record
        $track->delete();

        return back()->with('success', 'Traccia eliminata e file rimossi dal disco.');
    }

    /**
     * FUNZIONE PRIVATA DI SINCRONIZZAZIONE
     * Crea un file JSON leggibile dal Raspberry Pi 4
     */
    private function syncRaspberryPlaylist()
    {
        $playlistData = Track::where('in_playlist', true)
            ->with('artist:id,name')
            ->get()
            ->map(function ($track) {
                return [
                    'id' => $track->id,
                    'title' => $track->title,
                    'artist' => $track->artist->name ?? 'Unknown',
                    'url' => asset('storage/' . $track->file_path), // URL assoluto per il player
                ];
            });

        // Salvataggio in storage/app/public/playlist.json
        Storage::disk('public')->put('radio/playlist.json', json_encode($playlistData, JSON_PRETTY_PRINT));
    }
}
