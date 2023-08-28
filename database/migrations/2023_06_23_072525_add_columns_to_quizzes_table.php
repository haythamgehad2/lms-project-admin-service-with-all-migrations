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
            $table->unsignedBigInteger("total_grade")->nullable();
            $table->unsignedBigInteger("success_grade")->nullable();
            $table->enum("calc_type", ["max", "average"])->default("max");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn("total_grade");
            $table->dropColumn("success_grade");
            $table->dropColumn("calc_type");
        });
    }
};
