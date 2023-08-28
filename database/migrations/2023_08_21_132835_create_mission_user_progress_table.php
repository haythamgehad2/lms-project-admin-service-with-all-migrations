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
        Schema::create('mission_user_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mission_id')->nullable();
            $table->foreign('mission_id')->references('id')->on('missions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('learning_path_id');
            $table->foreign('learning_path_id')->references('id')->on('learning_paths')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->bigInteger('total_path_jc');
            $table->bigInteger('total_path_xp');
            $table->bigInteger('total_videos_xp')->default(0);
            $table->bigInteger('total_videos_jc')->default(0);
            $table->bigInteger('total_participatory_paper_works_xp')->default(0);
            $table->bigInteger('total_participatory_paper_works_js')->default(0);
            $table->bigInteger('total_single_paper_works_xp')->default(0);
            $table->bigInteger('total_single_paper_works_jc')->default(0);
            $table->bigInteger('total_quizzes_jc')->default(0);
            $table->bigInteger('total_quizzes_xp')->default(0);
            $table->index(['mission_id','learning_path_id']);
            $table->index(['mission_id']);
            $table->index(['learning_path_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_user_progress');
    }
};
