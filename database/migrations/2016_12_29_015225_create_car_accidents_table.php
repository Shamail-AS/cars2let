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
            $table->dateTime('incident_at');
            $table->string('location');
            $table->string('type');
            $table->string('weather_cond');
            $table->string('road_cond');
            $table->text('police_details');
            $table->text('comments');
            $table->string('status'); // open, more-info, police-case, insured, settled, closed
            $table->string('x_car_reg'); // x_whatever -> details of third party
            $table->string('x_car_details');
            $table->string('x_driver_name');
            $table->string('x_driver_licence');
            $table->string('x_insured_name');
            $table->string('x_insured_comp');
            $table->string('x_insured_policy');
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
        Schema::drop('car_accidents');
    }
}
