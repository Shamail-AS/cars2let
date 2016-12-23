<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imei');
            $table->string('model');
            $table->integer('supplier_id');
            //$table->integer('sim_id');
            $table->integer('car_id')->nullable();
            $table->date('installed_at')->nullable();
            $table->string('status'); // ordered, delivered, fitted, faulty, removed, deactivated
            $table->string('comments');
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
        Schema::drop('trackers');
    }
}
