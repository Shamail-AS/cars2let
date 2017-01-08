<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractHandoverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_handovers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('car_id');
            $table->integer('driver_id');
            $table->integer('contract_id');
            $table->string('handover_date');
            $table->string('type');
            $table->string('status');
            $table->string('odo_meter_reading');
            $table->text('comments');
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
    }
}
