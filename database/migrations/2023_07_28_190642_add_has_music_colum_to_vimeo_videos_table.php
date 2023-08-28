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
        Schema::table('vimeo_videos', function (Blueprint $table) {
            $table->boolean("has_music")->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vimeo_videos', function (Blueprint $table) {
            $table->dropColumn("has_music");
        });
    }
};
