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
    Schema::table('artists', function (Blueprint $table) {
        if (!Schema::hasColumn('artists', 'style')) $table->string('style')->nullable();
        if (!Schema::hasColumn('artists', 'soundcloud_url')) $table->string('soundcloud_url')->nullable();
        if (!Schema::hasColumn('artists', 'spotify_url')) $table->string('spotify_url')->nullable();
        if (!Schema::hasColumn('artists', 'instagram_url')) $table->string('instagram_url')->nullable();
        if (!Schema::hasColumn('artists', 'ln_address')) $table->string('ln_address')->nullable();
        if (!Schema::hasColumn('artists', 'nostr_npub')) $table->string('nostr_npub')->nullable();
        if (!Schema::hasColumn('artists', 'profile_image')) $table->string('profile_image')->nullable();
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
