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
        Schema::table('blog_ads', function (Blueprint $table) {
            $table->unsignedBigInteger('views_count')->default(0)->after('is_active');
            $table->unsignedBigInteger('clicks_count')->default(0)->after('views_count');
            
            $table->index('views_count');
            $table->index('clicks_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_ads', function (Blueprint $table) {
            $table->dropIndex(['views_count']);
            $table->dropIndex(['clicks_count']);
            $table->dropColumn(['views_count', 'clicks_count']);
        });
    }
};
