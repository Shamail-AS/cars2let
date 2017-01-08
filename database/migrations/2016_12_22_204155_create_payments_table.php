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
            $table->string('type')->default('bank'); //card, cash, cheque, bank
            $table->integer('bank_account_id')->nullable();
            $table->integer('contract_id')->nullable(); // for when a payment is recorded against a contract
            $table->string('from')->nullable(); // in case it's from a non user (council)
            $table->string('to')->nullable(); //in case it's to a non user (drover)
            $table->integer('auth_user_id');
            $table->string('auth_user')->nullable(); //FREE TEXT
            $table->string('comments')->nullable();
            $table->date('value_dt');
            $table->decimal('amount');
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
