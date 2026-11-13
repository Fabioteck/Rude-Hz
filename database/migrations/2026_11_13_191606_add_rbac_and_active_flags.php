<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('artist')->after('email');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('role');
            }
            if (!Schema::hasColumn('users', 'assigned_category_id')) {
                $table->unsignedBigInteger('assigned_category_id')->nullable()->after('is_active');
            }
        });

        Schema::table('artists', function (Blueprint $table) {
            if (!Schema::hasColumn('artists', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('name');
            }
        });

        Schema::table('tracks', function (Blueprint $table) {
            if (!Schema::hasColumn('tracks', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_active', 'assigned_category_id']);
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn(['is_active']);
        });

        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn(['is_active']);
        });
    }
};
