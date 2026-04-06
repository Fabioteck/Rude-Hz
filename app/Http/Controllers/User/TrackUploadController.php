<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class TrackUploadController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all(), $request->file('audio_file')); 
        // 1. Validazione (aggiunto audio_file per coerenza con il form)
        $request->validate([
            'title' => 'required|string|max:255',
            'audio_file' => 'required|mimes:mp3,wav,ogg|max:20480', 
            'genre' => 'required|string',
            'bpm' => 'nullable|integer',
        ]);

        // 2. Controllo Artista
        $artist = Artist::where('user_id', auth()->id())->first();
        
        if (!$artist) {
            return back()->with('error', 'Devi prima completare il tuo profilo artista!');
        }

        // 3. Salvataggio File Audio
        $path = $request->file('audio_file')->store('tracks/audio', 'public');

        // 4. Generazione Slug e URL
        $slug = Str::slug($request->title . '-' . Str::random(5));
        $trackUrl = url('/track/' . $slug);

        // 5. Generazione & Salvataggio QR Code (CORRETTO)
        $qrName = 'qrcode-' . $slug . '.svg';
        $qrPath = 'tracks/qrcodes/' . $qrName;
        
        // Generiamo il contenuto del QR
        $qrCodeContent = QrCode::size(300)
            ->color(217, 255, 0) // Verde Acido #d9ff00
            ->backgroundColor(10, 10, 10)
            ->format('svg')
            ->generate($trackUrl);

        // Salviamo il file tramite lo Storage
        Storage::disk('public')->put($qrPath, $qrCodeContent);

        // 6. Salvataggio nel Database
        Track::create([
            'title' => $request->title,
            'slug' => $slug,
            'version' => $request->version ?? 'Original Mix', // Aggiunto per il tuo form
            'genre' => $request->genre,
            'bpm' => $request->bpm,
            'release_year' => $request->release_year ?? date('Y'),
            'label' => $request->label,
            'isrc_code' => $request->isrc_code,
            'file_path' => $path,
            'qr_code_path' => $qrPath,
            'user_id' => auth()->id(),
            'artist_id' => $artist->id,
            'is_approved' => false,
            'is_featured' => false,
        ]);

        return back()->with('success', 'Traccia caricata con successo! Ora è in attesa di validazione.');
    }
}
