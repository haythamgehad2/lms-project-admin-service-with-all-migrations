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
        // mission_id,path_id,total_path_xp,total_path_jc,total_videos_xp,total_videos_jc,total_paper_work_xp etc....
        Schema::create('mission_progress_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mission_id')->nullable();
            $table->foreign('mission_id')->references('id')->on('missions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('learning_path_id');
            $table->foreign('learning_path_id')->references('id')->on('learning_paths')->cascadeOnDelete()->cascadeOnUpdate();
            $table->bigInteger('total_path_jc');
            $table->bigInteger('total_path_xp');
            $table->bigInteger('total_videos_xp');
            $table->bigInteger('total_videos_jc');
            $table->bigInteger('total_participatory_paper_works_xp');
            $table->bigInteger('total_participatory_paper_works_jc');
            $table->bigInteger('total_single_paper_works_xp');
            $table->bigInteger('total_single_paper_works_jc');
            $table->bigInteger('total_quizzes_jc');
            $table->bigInteger('total_quizzes_xp');
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
        Schema::dropIfExists('mission_progress_details');
    }
};
