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
        Schema::create('reward_actions', function (Blueprint $table) {
            $table->id();
            $table->string("action_name");
            $table->string("action_desc");
            $table->string("action_unique_name")->unique("action_unique_name_index");
            $table->string("model_type")->nullable();
            $table->unsignedBigInteger("jeel_coins");
            $table->unsignedBigInteger("second_jeel_coins")->default(0);
            $table->unsignedBigInteger("next_jeel_coins")->default(0);
            $table->unsignedBigInteger("jeel_xp");
            $table->unsignedBigInteger("second_jeel_xp")->default(0);
            $table->unsignedBigInteger("next_jeel_xp")->default(0);
            $table->unsignedBigInteger("max_trail")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_actions');
    }
};
