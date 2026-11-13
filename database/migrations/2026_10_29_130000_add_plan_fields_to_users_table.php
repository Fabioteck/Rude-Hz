<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'plan')) {
                $table->string('plan')->default('free');
            }
            if (!Schema::hasColumn('users', 'plan_expires_at')) {
                $table->timestamp('plan_expires_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'supporter_badge')) {
                $table->boolean('supporter_badge')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'plan')) {
                $table->dropColumn('plan');
            }
            if (Schema::hasColumn('users', 'plan_expires_at')) {
                $table->dropColumn('plan_expires_at');
            }
            if (Schema::hasColumn('users', 'supporter_badge')) {
                $table->dropColumn('supporter_badge');
            }
        });
    }
};
