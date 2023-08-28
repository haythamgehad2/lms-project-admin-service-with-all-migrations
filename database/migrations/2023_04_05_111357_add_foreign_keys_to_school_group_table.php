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
        Schema::table('school_groups', function (Blueprint $table) {
            $table->foreign(['country_id'], 'country_group')->references(['id'])->on('countries')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['owner_id'], 'owner_user')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_groups', function (Blueprint $table) {
            $table->dropForeign('country_group');
            $table->dropForeign('owner_user');
        });
    }
};
