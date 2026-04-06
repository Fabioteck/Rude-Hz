<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::table('artists', function (Blueprint $table) {
        // --- Social Estesi ---
        $table->string('soundcloud_url')->nullable();
        $table->string('facebook_url')->nullable();
        $table->string('instagram_url')->nullable();
        $table->string('spotify_url')->nullable();
        $table->string('youtube_url')->nullable();
        $table->string('apple_music_url')->nullable();
        
        // --- Web3 & Lightning Network (Zaps & Tips) ---
        $table->string('ln_address')->nullable(); // Es: fabio@getalby.com (per la LNURL-pay)
        $table->string('lightning_wallet')->nullable(); // Indirizzo Wallet / PubKey
        $table->string('nostr_npub')->nullable(); // Il profilo Nostr (fondamentale per la censura)
        
        // --- Media ---
        $table->string('profile_image')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            //
        });
    }
};
