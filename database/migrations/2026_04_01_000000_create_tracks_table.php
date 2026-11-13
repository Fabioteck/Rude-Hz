<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            
            // --- DATI IDENTIFICATIVI ---
            $table->string('title'); // Titolo della traccia
            $table->string('slug')->unique(); // Per URL puliti e QR Code (es: rude-hz.it/track/acid-rain)
            $table->string('version')->default('Original Mix'); // Remix, Edit, etc.
            
            // --- DATI TECNICI ---
            $table->integer('bpm')->nullable();
            $table->string('key')->nullable(); // Tonalità (es: 4A, Am)
            $table->string('genre')->default('Techno');
            $table->year('release_year')->nullable();
            
            // --- DISTRIBUZIONE & COPYRIGHT ---
            $table->string('label')->nullable(); // Etichetta discografica
            $table->string('isrc_code')->nullable()->unique(); // Codice standard internazionale
            $table->boolean('is_published')->default(false); // Se è già uscita ufficialmente
            $table->string('buy_link')->nullable(); // Link a Beatport/Bandcamp
            
            // --- FILE & MEDIA ---
            $table->string('file_path'); // Percorso del file audio .mp3/.wav
            $table->string('cover_path')->nullable(); // Immagine di copertina della traccia
            $table->string('qr_code_path')->nullable(); // Percorso dell'immagine QR generata
            
            // --- RELAZIONI & MODERAZIONE ---
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Chi l'ha caricata (User)
            $table->foreignId('artist_id')->constrained()->onDelete('cascade'); // L'artista associato
            
            // Il tuo "bottoncino" di validazione
            $table->boolean('is_approved')->default(false); 
            $table->boolean('is_featured')->default(false); // Per la sezione "In evidenza" nella Home
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
