<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('housing_types', function (Blueprint $table) {
            $table->string('image_tampak_depan')->nullable()->after('floor_plan');
            $table->string('image_ruang_tamu')->nullable()->after('image_tampak_depan');
            $table->string('image_kamar')->nullable()->after('image_ruang_tamu');
            $table->string('image_dapur')->nullable()->after('image_kamar');
            $table->json('custom_images')->nullable()->after('image_dapur');
        });
    }

    public function down(): void
    {
        Schema::table('housing_types', function (Blueprint $table) {
            $table->dropColumn([
                'image_tampak_depan',
                'image_ruang_tamu',
                'image_kamar',
                'image_dapur',
                'custom_images'
            ]);
        });
    }
};
