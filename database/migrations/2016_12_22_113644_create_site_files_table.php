<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('origin_id');
            $table->string('origin_type'); // POLYMORPHIC RELATION
            $table->string('name');
            $table->string('type')->default('image');
            $table->string('full_url');
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
        Schema::drop('site_files');
    }
}
