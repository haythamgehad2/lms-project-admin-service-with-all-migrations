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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('is_super_admin')->default(false);
            $table->integer('failed_attempts')->nullable();
            $table->integer('status')->default(1);
            $table->integer('verification_code')->nullable();
            $table->dateTime('verification_sent_at')->nullable();
            $table->integer('lang_id')->default(1);
            $table->string('mobile', 40)->nullable();
            $table->json('bio')->nullable();
            $table->json('social_media')->nullable();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnUpdate();
            $table->boolean('is_school_admin')->default(0);
            $table->date('last_attempt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
