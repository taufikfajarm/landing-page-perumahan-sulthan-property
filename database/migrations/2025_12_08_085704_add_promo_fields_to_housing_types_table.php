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
        Schema::table('housing_types', function (Blueprint $table) {
            $table->string('promo_title')->nullable();
            $table->text('promo_description')->nullable();
            $table->date('promo_valid_until')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('housing_types', function (Blueprint $table) {
            $table->dropColumn(['promo_title', 'promo_description', 'promo_valid_until']);
        });
    }
};
