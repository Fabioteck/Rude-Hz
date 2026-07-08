<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esegue la migrazione aggiungendo i campi mancanti.
     */
       public function up(): void
    {
        Schema::table('analytics', function (Blueprint $table) {
            // Aggiungiamo tutti i campi necessari al tracciamento avanzato
            if (!Schema::hasColumn('analytics', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('analytics', 'session_id')) {
                $table->string('session_id')->nullable()->index();
            }
            if (!Schema::hasColumn('analytics', 'ip_address')) {
                $table->string('ip_address', 45)->nullable();
            }
            if (!Schema::hasColumn('analytics', 'user_agent')) {
                $table->text('user_agent')->nullable();
            }
            if (!Schema::hasColumn('analytics', 'url_path')) {
                $table->string('url_path')->nullable()->index();
            }
            if (!Schema::hasColumn('analytics', 'referrer_url')) {
                $table->text('referrer_url')->nullable();
            }
            if (!Schema::hasColumn('analytics', 'device_type')) {
                $table->string('device_type', 50)->nullable();
            }
            if (!Schema::hasColumn('analytics', 'browser_name_version')) {
                $table->string('browser_name_version', 100)->nullable();
            }
            if (!Schema::hasColumn('analytics', 'country_code')) {
                $table->string('country_code', 3)->nullable();
            }
            if (!Schema::hasColumn('analytics', 'duration')) {
                $table->unsignedInteger('duration')->default(0);
            }
        });
    }

    /**
     * Inverte la migrazione rimuovendo i campi.
     */
    public function down(): void
    {
        Schema::table('analytics', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'session_id', 'duration', 'country_code']);
        });
    }
};
