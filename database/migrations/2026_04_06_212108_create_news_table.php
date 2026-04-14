<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            // Autore della news collegato alla tabella users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Contenuto Editoriale
            $table->string('title');
            $table->string('slug')->unique(); // Per URL SEO-friendly
            $table->text('content');
            $table->string('image_path')->nullable(); // Cover della notizia
            
            // --- Integrazione Social/Nostr ---
            // event_id per tracciare il post corrispondente sul protocollo Nostr
            $table->string('nostr_event_id')->nullable()->index();
            
            // Stato di pubblicazione
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
