<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contest_track', function (Blueprint $table) {
    $table->id();
    $table->foreignId('contest_id')->constrained()->onDelete('cascade');
    $table->foreignId('track_id')->constrained()->onDelete('cascade');
    
    // Logica di consenso legale
    // Registriamo che l'artista ha accettato la liberatoria specifica di questo contest
    $table->boolean('accepted_legal_terms')->default(false);
    $table->timestamp('accepted_at')->nullable();
    
    $table->string('status')->default('pending'); // pending, approved, finalist, winner
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contest_track');
    }
};
