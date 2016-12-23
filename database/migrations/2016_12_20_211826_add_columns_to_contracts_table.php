<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('contracts', function (Blueprint $table) {
            $table->date('act_start_dt');
            $table->date('act_end_dt');
            $table->date('handover_at');
            $table->decimal('req_deposit')->default(500);
            $table->decimal('rec_deposit');
            $table->decimal('start_odo_reading');
            $table->decimal('end_odo_reading')->nullable();
            $table->string('handover_form')->nullable();
            $table->string('contract_doc')->nullable();

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
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn([
                'act_start_dt',
                'act_end_dt',
                'handover_at',
                'req_deposit',
                'rec_deposit',
                'start_odo_reading',
                'end_odo_reading',
                'handover_form',
                'contract_doc'
            ]);
        });
    }
}
