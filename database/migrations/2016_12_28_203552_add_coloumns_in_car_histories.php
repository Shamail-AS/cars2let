<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColoumnsInCarHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_histories', function ($table) {
            $table->integer('car_id');
            $table->integer('historable_id');
            $table->string('historable_type'); // POLYMORPHIC RELATION
            $table->text('comments');
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
        Schema::table('car_histories', function ($table) {
            $table->dropColumn([
                'car_id',
                'historable_id',
                'historable_type',
                'comments'
            ]);
        });
    }
}
