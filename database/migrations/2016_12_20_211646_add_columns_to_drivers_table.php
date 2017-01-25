<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('drivers', function (Blueprint $table) {
            //PERSONAL
            $table->string('address');
            $table->string('alt_address');
            $table->string('passport')->nullable();
            $table->date('pass_exp_at')->nullable();
            $table->string('nationality');
            $table->string('emerg_person');
            $table->string('emerg_num');
            $table->integer('years_in_uk')->nullable();

            //EMPLOYMENT
            $table->date('pco_expires_at');
            $table->date('licence_exp_at');
            $table->string('type')->default('self');
            $table->string('nino');
            $table->string('right_to_work'); //Yes, No, N/A

            //DRIVING
            $table->date('driving_licence_start_date');
            $table->date('driving_mini_cab_from');
            $table->integer('uber_rating');
            $table->integer('penalty_points')->default(0);
            $table->string('history')->nullable();
            $table->string('comments')->nullable();
            //BACKGROUND
            $table->boolean('can_dbs_check')->default(false);
            $table->boolean('dbs_checked')->default(false);

            //PAYMENTS
            $table->integer('bank_account_id')->nullable();
            $table->string('pay_method')->default('bank');
            $table->integer('week_pay_day')->default(0); //0 - 6 : 7 days

            $table->integer('approved_by')->unsigned()->nullable();

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
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'passport',
                'pass_exp_at',
                'nationality',
                'emerg_person',
                'emerg_num',
                'years_in_uk',
                'pco_expires_at',
                'licence_exp_at',
                'type',
                'nino',
                'right_to_work',
                'driving_since',
                'penalty_points',
                'history',
                'can_dbs_check',
                'dbs_checked',
                'bank_account_id',
                'pay_method',
                'week_pay_day',
                'approved_by'
            ]);

        });
    }
}
