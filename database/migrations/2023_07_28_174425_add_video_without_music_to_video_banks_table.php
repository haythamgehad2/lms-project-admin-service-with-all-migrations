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
        Schema::table('video_banks', function (Blueprint $table) {
            $table->string('video_without_music_disk')->nullable();
            $table->string('video_without_music_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_banks', function (Blueprint $table) {
            $table->dropColumn("video_without_music_disk");
            $table->dropColumn("video_without_music_path");
        });
    }
};
