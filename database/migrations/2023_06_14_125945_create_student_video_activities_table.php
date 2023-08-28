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
        Schema::create('student_video_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools');
            $table->unsignedBigInteger('mission_id');
            $table->foreign('mission_id')->references('id')->on('missions');
            $table->unsignedBigInteger('learning_path_id');
            $table->foreign('learning_path_id')->references('id')->on('learning_paths');
            $table->unsignedBigInteger('video_id');
            $table->foreign('video_id')->references('id')->on('video_banks');
            $table->bigInteger('time')->nullable();
            $table->bigInteger('last_view_time');
            $table->bigInteger('times_view')->nullable();
            $table->enum('status',['in-progress','completed'])->default('in-progress');
            $table->index(['user_id', 'video_id']);
            $table->index(['user_id', 'video_id','learning_path_id']);
            $table->index(['user_id', 'video_id','mission_id']);
            $table->index(['user_id', 'school_id']);
            $table->index(['user_id', 'status']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_video_activities');
    }
};
