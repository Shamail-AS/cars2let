<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type'); //card, cash, cheque
            $table->integer('bank_account_id')->nullable();
            $table->string('from'); // in case it's to a non user (council)
            $table->string('to'); //in case it's from a non user (drover)
            $table->integer('auth_user_id');
            $table->string('comments');
            $table->date('paid_on');
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
        Schema::drop('payments');
    }
}
