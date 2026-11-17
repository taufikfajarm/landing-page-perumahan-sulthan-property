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
            $table->string('developer_name')->nullable()->default('PT. Hanaan Jaya Abadi')->after('name');
            $table->string('certificate_type')->nullable()->default('SHM & PBG')->after('developer_name');
            $table->string('brochure_file')->nullable()->after('siteplan_sip_id');
            $table->string('video_url')->nullable()->after('brochure_file');
            $table->string('meta_title')->nullable()->after('video_url');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('housings', function (Blueprint $table) {
            $table->dropColumn([
                'developer_name',
                'certificate_type',
                'brochure_file',
                'video_url',
                'meta_title',
                'meta_description',
                'meta_keywords',
            ]);
        });
    }
};
