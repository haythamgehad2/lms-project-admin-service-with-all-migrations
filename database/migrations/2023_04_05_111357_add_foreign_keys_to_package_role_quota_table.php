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
        Schema::table('package_role_quota', function (Blueprint $table) {
            $table->foreign(['package_id'], 'package_role')->references(['id'])->on('packages')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['role_id'], 'role_package')->references(['id'])->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_role_quota', function (Blueprint $table) {
            $table->dropForeign('package_role');
            $table->dropForeign('role_package');
        });
    }
};
