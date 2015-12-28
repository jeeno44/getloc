<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksTable extends Migration
{
    public function up()
    {
        Schema::create('blocks', function(Blueprint $table){
            $table->increments('id');
            $table->integer('site_id', false, true)->nullable();
            $table->text('text');
            $table->string('type', 5);
            $table->integer('count_words');
            $table->integer('count_symbols');
            $table->timestamps();
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('sites');
    }
}
