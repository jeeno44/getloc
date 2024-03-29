<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    public function up()
    {
        Schema::create('sites', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id', false, true)->nullable();
            $table->integer('language_id', false, true)->nullable();
            $table->string('name')->index();;
            $table->string('url')->index();;
            $table->string('secret', 64)->index();;
            $table->integer('count_blocks');
            $table->integer('count_words');
            $table->integer('count_symbols');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {

    }
}
