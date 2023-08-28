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
        Schema::create('question_difficulties', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug');
            $table->boolean('is_default')->default('0');
            $table->integer('xp')->default(0);
            $table->integer('coins')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_difficulties');
    }
};
