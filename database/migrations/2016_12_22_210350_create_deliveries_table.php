<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->date('scheduled_at');
            $table->date('delivered_at')->nullable();
            $table->integer('rec_user_id')->nullable();
            $table->string('received_by')->nullable();
            $table->string('comments');
            $table->string('type');
            $table->integer('order_id')->nullable(); // To accommodate for order deliveries.
            $table->string('order_type')->nullable();
            $table->integer('car_id'); // To accommodate for non-purchase delivery types
            $table->string('condition');// A grade, B, C, D, E, F, Custom Text
            $table->integer('odo_reading');
            $table->string('location');
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
        Schema::drop('deliveries');
    }
}
