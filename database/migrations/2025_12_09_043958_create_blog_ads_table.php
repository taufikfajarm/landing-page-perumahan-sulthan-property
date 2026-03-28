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
        Schema::create('blog_ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('housing_id')->nullable()->constrained('housings')->onDelete('set null');
            $table->foreignId('marketing_id')->constrained('marketing')->onDelete('cascade');
            $table->string('image');
            $table->enum('ad_type', ['banner', 'card'])->default('card');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index('is_active');
            $table->index('ad_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_ads');
    }
};
