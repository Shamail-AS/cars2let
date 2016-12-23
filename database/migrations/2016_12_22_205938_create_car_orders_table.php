<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_id');
            $table->integer('car_id');
            $table->string('status');
            $table->decimal('cost');
            $table->string('auth_user'); // FREE TEXT
            $table->string('comments');
            //$table->integer('delivery_id');
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
        Schema::drop('car_orders');
    }
}
