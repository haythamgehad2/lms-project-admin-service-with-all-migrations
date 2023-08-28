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
        Schema::create('peper_works', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('description');
            $table->string('disk')->nullable();
            $table->string('path')->nullable();
            $table->enum('type',['participatory','single'])->default('single');
            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('learning_path_id');
            $table->foreign('learning_path_id')->references('id')->on('learning_paths')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('paper_work_without_color_disk');
            $table->string('paper_work_without_color_path');
            $table->integer('paper_work_final_degree');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pepar_works');
    }
};
