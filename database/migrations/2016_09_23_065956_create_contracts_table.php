<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id');
            $table->integer('driver_id');
            $table->string('status');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('rate');
            $table->string('currency');
            $table->timestamps();
            $table->softDeletes();


//            $table->foreign('car')->references('id')->on('cars');
//            $table->foreign('driver')->references('id')->on('drivers');
//            $table->foreign('investor')->references('id')->on('investors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contracts');
    }
}
