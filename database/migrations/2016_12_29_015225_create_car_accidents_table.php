<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarAccidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_accidents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id');
            $table->integer('driver_id');
            $table->timestamp('time_of_accident');
            $table->string('type_of_accident');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
