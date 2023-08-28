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
        Schema::create('student_paper_works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('paper_work_id')->nullable();
            $table->foreign('paper_work_id')->references('id')->on('peper_works')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('paper_work_without_color_disk');
            $table->string('paper_work_without_color_path');
            $table->integer('student_final_degree')->default(0);
            $table->enum('status_teacher',['reviewed','not_reviewed'])->default('not_reviewed');
            $table->enum('status_parent',['pending','accept','rejected'])->default('pending');
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_paper_works');
    }
};
