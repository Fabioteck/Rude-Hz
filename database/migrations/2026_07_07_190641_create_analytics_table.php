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
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('isp_name')->nullable();
            $table->string('asn')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('country')->nullable();
            $table->string('connection_type')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('browser_name_version')->nullable();
            $table->string('device_type')->nullable();
            $table->string('screen_resolution')->nullable();
            $table->string('browser_language')->nullable();
            $table->string('referrer_url')->nullable();
            $table->string('current_url')->nullable();
            $table->boolean('is_bot')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};
