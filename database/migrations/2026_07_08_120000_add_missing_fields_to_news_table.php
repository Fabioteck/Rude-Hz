<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('news')) {
            Schema::table('news', function (Blueprint $table) {
                if (!Schema::hasColumn('news', 'subtitle')) {
                    $table->string('subtitle')->nullable()->after('title');
                }
                if (!Schema::hasColumn('news', 'category_id')) {
                    $table->foreignId('category_id')->nullable()->constrained('news_categories')->nullOnDelete()->after('id');
                }
                if (!Schema::hasColumn('news', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('category_id');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('news')) {
            Schema::table('news', function (Blueprint $table) {
                if (Schema::hasColumn('news', 'subtitle')) {
                    $table->dropColumn('subtitle');
                }
                if (Schema::hasColumn('news', 'category_id')) {
                    $table->dropForeign(['category_id']);
                    $table->dropColumn('category_id');
                }
                if (Schema::hasColumn('news', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                }
            });
        }
    }
};
