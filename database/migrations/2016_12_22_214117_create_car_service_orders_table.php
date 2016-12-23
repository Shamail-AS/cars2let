<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_service_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id');
            $table->integer('supplier_id');
            $table->string('comments');
            $table->string('type');
            $table->date('handover_date');
            $table->integer('insur_claim_id')->nullable();
            $table->string('status');
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
        Schema::drop('car_service_orders');
    }
}
