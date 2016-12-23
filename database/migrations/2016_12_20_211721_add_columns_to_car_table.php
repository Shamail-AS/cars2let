<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('cars', function (Blueprint $table) {
            $table->string('custom_id')->nullable();
            $table->string('supplier_id');
            //$table->integer('garage_id');
            $table->string('model');
            $table->integer('year');
            $table->string('colour');
            $table->string('transmission');
            $table->string('fuel_type');
            $table->string('chassis_num');
            $table->string('engine_size');
            $table->date('first_reg_date');
            $table->string('keeper');

            //$table->integer('camera_id');
            //$table->date('cam_installed_at');
            $table->string('pco_licence');
            $table->date('pco_expires_at');
            //$table->integer('tracker_id');
            $table->string('status');
            $table->integer('curr_odo');
            $table->date('odo_read_at');
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
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn([
                'custom_id',
                'supplier_id',
                //'garage_id',
                'model',
                'year',
                'colour',
                'transmission',
                'fuel_type',
                'chassis_num',
                'engine_size',
                'first_reg_date',
                'keeper',

                //'camera_id',
                //'cam_installed_at',
                'pco_licence',
                'pco_expires_at',
                //'tracker_id',
                'status',
                'curr_odo',
                'odo_read_at'
            ]);
        });
    }
}
