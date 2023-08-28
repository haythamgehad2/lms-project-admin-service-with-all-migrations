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
        Schema::create('vimeo_videos', function (Blueprint $table) {
            $table->id();
            $table->string("vimeo_video_id")->nullable();
            $table->unsignedBigInteger("video_bank_id");
            $table->boolean("is_fully_uploaded")->default(false);
            $table->json("vimeo_response");
            $table->string("vimeo_private_link")->nullable();
            $table->string("upload_error")->nullable();
            $table->boolean("is_replaced")->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vimeo_videos');
    }
};
