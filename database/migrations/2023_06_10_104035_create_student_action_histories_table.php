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
        Schema::create('student_action_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id");
            $table->unsignedBigInteger("reward_action_id");
            $table->string("model_type")->nullable();
            $table->unsignedBigInteger("model_id")->nullable();
            $table->unsignedBigInteger('mission_id')->nullable();
            $table->foreign('mission_id')->references('id')->on('missions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger("jeel_coins")->default(0);
            $table->unsignedBigInteger("jeel_xp")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_action_histories');
    }
};
