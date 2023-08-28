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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->json('question');
            $table->string('question_audio')->nullable();
            $table->unsignedBigInteger('question_type_id');
            $table->foreign('question_type_id')->references('id')->on('question_types');
            $table->unsignedBigInteger('question_type_sub_id');
            $table->foreign('question_type_sub_id')->references('id')->on('question_types');
            $table->unsignedBigInteger('learning_path_id');
            $table->foreign('learning_path_id')->references('id')->on('learning_paths')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('question_difficulty_id');
            $table->foreign('question_difficulty_id')->references('id')->on('question_difficulties');
            $table->unsignedBigInteger('language_skill_id');
            $table->foreign('language_skill_id')->references('id')->on('language_skills')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('bloom_category_id');
            $table->foreign('bloom_category_id')->references('id')->on('bloom_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('language_method_id');
            $table->foreign('language_method_id')->references('id')->on('language_methods')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->json('hint');
            $table->enum('question_pattern',['image','text'])->default('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
