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
            $table->string('ticket_num');
            $table->integer('car_id');
            $table->date('latest_due_date')->nullable();
            $table->string('status')->nullable(); // PaidC2L,TA,TA,TP,TR,TP,U
            $table->date('actual_due_date')->nullable();
            $table->dateTime('incident_dt')->nullable();
            $table->date('date_of_notice')->nullable();
            $table->string('type')->nullable(); // First Notice, Second Notice, acceptance, Rejection, enforcement
            $table->string('website')->nullable();
            $table->date('paid_date')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('liability_of')->nullable();
            $table->integer('driver_id')->nullable();
            $table->string('case_handler')->nullable();
            $table->string('payment_account')->nullable();
            $table->string('authorized_by')->nullable();
            $table->text('comments')->nullable();
          

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
        Schema::drop('car_tickets');
    }
}
