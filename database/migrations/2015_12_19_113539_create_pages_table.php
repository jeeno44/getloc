<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function(Blueprint $table){
            $table->increments('id');
            $table->integer('site_id', false, true)->nullable();
            $table->string('url', 500);
            $table->string('code');
            $table->integer('level');
            $table->boolean('visited');
            $table->boolean('collected');
            $table->timestamps();
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });
    }

    public function down()
    {

    }
}
