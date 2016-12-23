<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('policy_num');
            $table->string('insurance_comp');
            $table->date('policy_start');
            $table->date('policy_end');
            $table->decimal('excess');
            $table->decimal('annual_insurance');
            $table->string('contactA'); //from insurance comp. All details in one
            $table->string('contactB'); //from insurance comp. All details in one
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
        Schema::drop('policies');
    }
}
