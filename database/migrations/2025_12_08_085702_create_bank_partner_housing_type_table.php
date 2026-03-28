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
        Schema::create('bank_partner_housing_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_partner_id')->constrained()->onDelete('cascade');
            $table->foreignId('housing_type_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_partner_housing_type');
    }
};
