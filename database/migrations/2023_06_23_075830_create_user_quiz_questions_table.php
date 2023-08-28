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
        Schema::create('user_quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_quiz_id");
            $table->unsignedBigInteger("question_id");
            $table->integer("attempts")->default(1);
            $table->integer("correct")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_quiz_questions');
    }
};
