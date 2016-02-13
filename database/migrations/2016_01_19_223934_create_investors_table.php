<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('name');
            $table->dateTime('dob');
            $table->string('passport_num');
            $table->string('phone');
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
        Schema::drop('investors');
    }
}
