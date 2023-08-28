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
        Schema::create('schools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name')->nullable();
            $table->unsignedBigInteger('school_group_id')->index('school_group_idx');
            $table->unsignedInteger('status')->default(1);
            $table->integer('music_status')->default(1);
            $table->unsignedBigInteger('admin_id')->index('school_user_idx');
            $table->unsignedBigInteger('school_type_id')->default(1)->index('school_type_idx');
            $table->unsignedBigInteger('logo_id')->nullable();
            $table->date('subscription_start_date')->nullable();
            $table->date('subscription_end_date')->nullable();
            $table->unsignedBigInteger('package_id')->index('school_package_idx');
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
        Schema::dropIfExists('schools');
    }
};
