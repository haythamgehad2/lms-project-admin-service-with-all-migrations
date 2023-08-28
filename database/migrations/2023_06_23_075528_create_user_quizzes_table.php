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
        Schema::create('user_quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->comment("student_id here");
            $table->unsignedBigInteger("quiz_id");
            $table->dateTime("start_solving");
            $table->dateTime("finish_solving")->nullable();
            $table->double("grade")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_quizzes');
    }
};
