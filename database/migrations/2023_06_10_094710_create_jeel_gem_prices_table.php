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
        Schema::create('jeel_gem_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("quantity");
            $table->unsignedBigInteger("jeel_coins_quantity");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jeel_gem_prices');
    }
};
