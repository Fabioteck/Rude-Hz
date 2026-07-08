<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->string('real_name')->nullable();
            $table->string('tax_code', 16)->nullable();
            $table->boolean('accepted_terms')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn(['real_name', 'tax_code', 'accepted_terms']);
        });
    }
};
