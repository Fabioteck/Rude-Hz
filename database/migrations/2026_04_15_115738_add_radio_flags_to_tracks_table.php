<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('tracks', function (Blueprint $table) {
        // Se non esistono già, aggiungiamo i controlli
        if (!Schema::hasColumn('tracks', 'is_approved')) {
            $table->boolean('is_approved')->default(false)->after('id');
        }
        if (!Schema::hasColumn('tracks', 'in_playlist')) {
            $table->boolean('in_playlist')->default(false)->after('is_approved');
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            //
        });
    }
};
