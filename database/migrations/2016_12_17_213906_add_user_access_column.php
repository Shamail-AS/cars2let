<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserAccessColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Add user access to the User class
        Schema::table('users', function (Blueprint $table) {
            $table->string("access_level");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop access_level
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('access_level');
        });
    }
}
