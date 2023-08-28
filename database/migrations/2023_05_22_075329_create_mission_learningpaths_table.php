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
        Schema::create('mission_learningpaths', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mission_id')->nullable();
            $table->foreign('mission_id')->references('id')->on('missions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('learning_path_id')->nullable();
            $table->foreign('learning_path_id')->references('id')->on('learning_paths')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('order')->nullable();
            $table->bigInteger('total_jc')->nullable();
            $table->bigInteger('total_xp')->nullable();
            $table->boolean('is_selected')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_learningpaths');
    }
};
