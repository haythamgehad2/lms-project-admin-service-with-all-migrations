<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->unsignedBigInteger('country_id')->index('country_group_idx');
            $table->boolean('status')->default(1);
            $table->enum('type',['international','national'])->default('international');
            $table->boolean('music_status')->default(1);
            $table->unsignedBigInteger('owner_id')->index('owner_user_idx');
            $table->string('username', 100)->nullable();
            $table->string('useremail', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_groups');
    }
};
