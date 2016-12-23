<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_file_id');
            $table->string('type')->default('pcn'); // PCN, FPN, Other
            $table->integer('ticket_num');
            $table->string('type'); // local council, dart charge, red route, congestion charge, low emission
            $table->integer('car_id');
            $table->integer('driver_id')->nullable();
            $table->dateTime('incident_dt');
            $table->date('issue_dt');
            $table->decimal('amount');
            $table->boolean('paid');
            $table->string('comments');
            $table->string('status'); //new , appealing, closed
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
        Schema::drop('p_c_ns');
    }
}
