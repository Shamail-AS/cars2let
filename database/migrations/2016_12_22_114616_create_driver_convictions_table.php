<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverConvictionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_convictions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('driver_id');
            $table->integer('car_ticket_id')->nullable();
            $table->string('details');
            $table->integer('penalty_points');
            $table->date('convicted_at');
            $table->string('place');
            $table->softDeletes();
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
        Schema::drop('driver_convictions');
    }
}
