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
        Schema::create('housing_access_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('housing_id')->constrained()->onDelete('cascade');
            $table->string('destination');
            $table->integer('duration_minutes');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_access_points');
    }
};
