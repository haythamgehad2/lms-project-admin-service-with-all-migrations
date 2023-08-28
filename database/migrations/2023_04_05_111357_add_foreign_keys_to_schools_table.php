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
        Schema::table('schools', function (Blueprint $table) {
            $table->foreign(['school_group_id'], 'school_groups')->references(['id'])->on('school_groups')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['package_id'], 'school_package')->references(['id'])->on('packages')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['school_type_id'], 'school_type')->references(['id'])->on('school_types')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['admin_id'], 'school_user')->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign('school_groups');
            $table->dropForeign('school_package');
            $table->dropForeign('school_type');
            $table->dropForeign('school_user');
        });
    }
};
