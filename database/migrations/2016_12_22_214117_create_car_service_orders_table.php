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
            $table->integer('supplier_id');
            $table->integer('car_id');
            $table->integer('auth_user_id');
            $table->string('auth_user'); //FREE TEXT
            $table->string('status');
            $table->string('comments');
            $table->integer('cost');
            $table->string('type');
            $table->date('handover_date');
            $table->string('handover_person');
            $table->integer('insurance_claim_id')->nullable();

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
        Schema::drop('car_service_orders');
    }
}
