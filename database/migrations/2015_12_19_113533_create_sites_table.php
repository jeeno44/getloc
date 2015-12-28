<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    public function up()
    {
        Schema::create('sites', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->integer('count_blocks');
            $table->integer('count_words');
            $table->integer('count_symbols');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('sites');
    }
}
