<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_id');
            $table->integer('item_id');
            $table->string('item_type'); // POLYMORPHIC RELATION
            //$table->integer('part_delivery_id');
            $table->string('status');
            $table->decimal('cost');
            $table->string('auth_user'); // FREE TEXT
            $table->string('comments');
            $table->softDeletes();
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
        Schema::drop('part_orders');
    }
}
