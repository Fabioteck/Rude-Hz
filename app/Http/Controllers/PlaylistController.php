<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mostra l'elenco delle playlist sul frontend pubblico con conteggio sicuro delle tracce.
     */
    public function index()
    {
        // Carichiamo il conteggio delle tracce collegate senza rischiare crash se la relazione è parziale
        $playlists = Playlist::withCount(['tracks' => function ($query) {
            return $query;
        }])
        ->latest()
        ->get();

        // Fallback di sicurezza: se la colonna tracks_count non si popola, impostiamo 0 per evitare errori nel ciclo Blade
        $playlists->transform(function ($playlist) {
            if (!isset($playlist->tracks_count)) {
                $playlist->tracks_count = 0;
            }
            return $playlist;
        });

        return view('playlists.index', compact('playlists'));
    }

        /**
     * Display the specified resource.
     * Mostra la singola playlist con il caricamento sicuro di tracce e artisti per il player.
     */
    public function show($slug)
    {
        // Recupera la playlist o lancia un errore 404 pulito se non esiste
        $playlist = Playlist::where('slug', $slug)->firstOrFail();
        
        // Eager loading sicuro delle tracce e degli artisti per ottimizzare le performance su SQLite
        try {
            $playlist->load(['tracks' => function($query) {
                // Ordina le tracce se hai una colonna pivot di ordinamento, altrimenti usa l'ordine di inserimento
                return $query;
            }, 'tracks.artist']);
        } catch (\Exception $e) {
            // Se le relazioni non sono ancora pronte o mancano tabelle pivot, evita il crash della pagina
            \Illuminate\Support\Facades\Log::warning('Impossibile caricare le relazioni della playlist: ' . $e->getMessage());
        }

        return view('playlists.show', compact('playlist'));
    }
}
