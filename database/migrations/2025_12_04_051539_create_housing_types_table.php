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
        Schema::create('housing_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('housing_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('floor_plan')->nullable();
            $table->integer('land_size')->nullable(); // in m²
            $table->integer('building_size')->nullable(); // in m²
            $table->integer('bedrooms')->default(0);
            $table->integer('bathrooms')->default(0);
            $table->decimal('price', 15, 2)->nullable();
            $table->json('specifications')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_types');
    }
};
