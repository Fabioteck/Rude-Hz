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
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description'); // HTML dall'editor
        $table->text('legal_disclaimer')->nullable(); // La liberatoria
        $table->string('image_path')->nullable();
        $table->string('rules_pdf')->nullable();
        $table->string('playlist_url')->nullable();
        $table->integer('max_tracks_per_artist')->default(1);
        $table->dateTime('start_date')->nullable();
        $table->dateTime('end_date')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contests');
    }
};
