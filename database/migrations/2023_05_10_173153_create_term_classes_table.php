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
        Schema::create('term_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id')->index('class_term_idx');
            $table->unsignedBigInteger('term_id')->index('term_class_idx');
            $table->timestamps();
            $table->foreign(['class_id'], 'class_term')->references(['id'])->on('classes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['term_id'], 'term_class')->references(['id'])->on('terms')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_classes');
    }
};
