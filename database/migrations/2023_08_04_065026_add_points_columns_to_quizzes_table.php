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
        Schema::table('quizzes', function (Blueprint $table) {
            $table->unsignedBigInteger("total_grade_points")->nullable();
            $table->unsignedBigInteger("easy_grade_point")->nullable();
            $table->unsignedBigInteger("medium_grade_point")->nullable();
            $table->unsignedBigInteger("hard_grade_point")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn("total_grade_points");
            $table->dropColumn("easy_grade_point");
            $table->dropColumn("medium_grade_point");
            $table->dropColumn("hard_grade_point");
        });
    }
};
