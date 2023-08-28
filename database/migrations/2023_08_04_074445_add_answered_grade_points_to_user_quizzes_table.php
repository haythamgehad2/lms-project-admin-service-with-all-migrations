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
        Schema::table('user_quizzes', function (Blueprint $table) {
            $table->unsignedBigInteger("answered_grade_points")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_quizzes', function (Blueprint $table) {
            $table->dropColumn("answered_grade_points");
        });
    }
};
