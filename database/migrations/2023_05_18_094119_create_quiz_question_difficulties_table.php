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
        Schema::create('quiz_question_difficulties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('question_difficulty_id');
            $table->foreign('question_difficulty_id')->references('id')->on('question_difficulties')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('total_question');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_question_difficulties');
    }
};
