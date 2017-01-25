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
            $table->date('warranty_exp_at');
            $table->date('road_side_exp_at');
            $table->date('road_tax_exp_at');
            $table->string('model');
            $table->integer('year');
            $table->string('colour');
            $table->string('transmission');
            $table->string('fuel_type');
            $table->string('chassis_num');
            $table->string('engine_size');
            $table->date('first_reg_date');
            $table->string('keeper');
            $table->string('price');
            $table->string('pco_licence');
            $table->date('pco_expires_at');
            $table->string('status');
            $table->integer('curr_odo');
            $table->date('odo_read_at');
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
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn([
                'custom_id',
                'supplier_id',
                'warranty_exp_at',
                'road_side_exp_at',
                'road_tax_exp_at',
                'model',
                'year',
                'colour',
                'transmission',
                'fuel_type',
                'chassis_num',
                'engine_size',
                'first_reg_date',
                'keeper',
                'pco_licence',
                'pco_expires_at',
                'status',
                'curr_odo',
                'odo_read_at',
                'approved_by'
            ]);
        });
    }
}
