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
        Schema::table('housings', function (Blueprint $table) {
            $table->string('badge_text')->nullable()->after('status');
            $table->enum('badge_type', ['success', 'danger', 'warning', 'info', 'primary'])->nullable()->after('badge_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('housings', function (Blueprint $table) {
            $table->dropColumn(['badge_text', 'badge_type']);
        });
    }
};
