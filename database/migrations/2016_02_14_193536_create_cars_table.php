<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investor_id');
            $table->string('reg_no')->unique();
            $table->string('make');
            $table->date('available_since');
            $table->string('comments');

            $table->timestamps();

//            $table->foreign('investor')->references('id')->on('investors');
//            $table->foreign('driver')->references('id')->on('drivers');
//            $table->foreign('contract')->references('id')->on('contracts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cars');
    }
}
