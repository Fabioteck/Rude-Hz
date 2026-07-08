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
        if (!Schema::hasColumn('tracks', 'cover_path')) {
            Schema::table('tracks', function (Blueprint $table) {
                $table->string('cover_path')->nullable()->after('qr_code_path');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('tracks', 'cover_path')) {
            Schema::table('tracks', function (Blueprint $table) {
                $table->dropColumn('cover_path');
            });
        }
    }
};
