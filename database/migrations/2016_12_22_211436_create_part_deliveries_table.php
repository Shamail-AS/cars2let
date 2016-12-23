<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('part_order_id');
            $table->date('scheduled_at');
            $table->date('delivered_at')->nullable();
            $table->integer('rec_user_id')->nullable();
            $table->string('received_by')->nullable();
            $table->string('comments');
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
        Schema::drop('part_deliveries');
    }
}
