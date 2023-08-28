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
        Schema::create('user_credits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->unique("user_index");
            $table->unsignedBigInteger("jeel_coins")->default(0);
            $table->unsignedBigInteger("jeel_gems")->default(0);
            $table->unsignedBigInteger("jeel_xp")->default(0);
            $table->unsignedBigInteger("level")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_credits');
    }
};
