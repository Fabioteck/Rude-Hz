<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TrackUploadController extends Controller
{
    use AuthorizesRequests;

    /**
     * Visualizza la lista delle tracce
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->artist) {
            return redirect()->route('user.studio')->with('error', 'Devi configurare il tuo profilo prima di gestire le tracce.');
        }

        $tracks = $user->artist->tracks()->latest()->get();
        return view('user.tracks.index', compact('tracks'));
    }

    /**
     * Caricamento nuova traccia
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'audio_file' => 'required|mimes:mp3,wav|max:10240', // 10MB limit
            'genre' => 'required|string',
            'version' => 'nullable|string|max:100',
            'bpm' => 'nullable|integer',
        ]);

        $artist = Auth::user()->artist;
        
        if (!$artist) {
            return back()->with('error', 'Completa prima il tuo profilo artista nello studio!');
        }

        // Salvataggio File Audio
        $path = $request->file('audio_file')->store('tracks/audio', 'public');

        // Generazione Slug unico
        $slug = Str::slug($request->title . '-' . Str::random(5));
        $trackUrl = url('/track/' . $slug);

        // Generazione QR Code (Verde Acido Rude-Hz)
        $qrPath = 'tracks/qrcodes/qrcode-' . $slug . '.svg';
        $qrCodeContent = QrCode::size(300)
            ->color(217, 255, 0) // #d9ff00
            ->backgroundColor(10, 10, 10)
            ->format('svg')
            ->generate($trackUrl);

        Storage::disk('public')->put($qrPath, $qrCodeContent);

        // Creazione Record
        Track::create([
            'user_id' => Auth::id(),
            'artist_id' => $artist->id,
            'title' => $request->title,
            'slug' => $slug,
            'version' => $request->version ?? 'Original Mix',
            'genre' => $request->genre,
            'bpm' => $request->bpm,
            'file_path' => $path,
            'qr_code_path' => $qrPath,
            'is_approved' => false,
            'release_year' => date('Y'),
        ]);

        return back()->with('success', 'Traccia inviata con successo! In attesa di convalida.');
    }

    /**
     * Pagina di Modifica (Il metodo che mancava)
     */
    public function edit(Track $track)
    {
        // Verifica proprietà (o tramite user_id o tramite artist_id)
        if ($track->user_id !== Auth::id()) {
            abort(403, 'Azione non autorizzata.');
        }

        return view('user.tracks.edit', compact('track'));
    }

    /**
     * Aggiornamento Metadati
     */
    public function update(Request $request, Track $track)
    {
        if ($track->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'bpm' => 'nullable|integer',
            'genre' => 'required|string',
            'version' => 'nullable|string|max:100',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            // Rimozione vecchia cover se esiste
            if ($track->cover_path && Storage::disk('public')->exists($track->cover_path)) {
                Storage::disk('public')->delete($track->cover_path);
            }
            $validated['cover_path'] = $request->file('cover_image')->store('tracks/covers', 'public');
        }

        // Escludiamo il campo file dal salvataggio diretto nel DB
        unset($validated['cover_image']);

        $track->update($validated);

        return redirect()->route('user.tracks.index')->with('success', 'Traccia aggiornata con successo.');
    }

    /**
     * Eliminazione totale file e record
     */
    public function destroy(Track $track)
    {
        if ($track->user_id !== Auth::id()) {
            abort(403);
        }

        // Rimozione file fisici
        $files = [$track->file_path, $track->qr_code_path];
        
        foreach ($files as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        $track->delete();

        return back()->with('success', 'Traccia e file rimossi definitivamente.');
    }
}
