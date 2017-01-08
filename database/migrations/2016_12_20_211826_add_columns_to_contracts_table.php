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
            $table->date('act_start_dt')->nullable();
            $table->date('act_end_dt')->nullable();

            $table->decimal('req_deposit')->default(500);
            $table->decimal('rec_deposit')->default(0);


            $table->text('comments')->nullable();

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
                'req_deposit',
                'rec_deposit',
                'comments'
            ]);
        });
    }
}
