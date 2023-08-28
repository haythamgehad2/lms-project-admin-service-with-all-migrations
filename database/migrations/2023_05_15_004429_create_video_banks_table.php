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
        Schema::create('video_banks', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->json('description');
            $table->string('original_name');
            $table->string('disk')->nullable();
            $table->string('path')->nullable();
            $table->string('stream_path')->nullable();
            $table->integer('order')->default(1);
            $table->boolean('processed')->nullable();
            $table->timestamp('converted_for_streaming_at')->nullable();
            $table->unsignedBigInteger('learning_path_id');
            $table->foreign('learning_path_id')->references('id')->on('learning_paths')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_banks');
    }
};
