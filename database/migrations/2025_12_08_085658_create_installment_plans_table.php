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
        Schema::create('installment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('housing_type_id')->constrained()->onDelete('cascade');
            $table->integer('tenor_months'); // 12, 24, 36, etc.
            $table->decimal('monthly_payment', 15, 2);
            $table->enum('dp_type', ['percentage', 'nominal'])->default('percentage');
            $table->decimal('dp_value', 15, 2)->nullable(); // DP value (% or Rp)
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_plans');
    }
};
