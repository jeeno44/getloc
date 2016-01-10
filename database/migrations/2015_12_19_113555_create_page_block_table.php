<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageBlockTable extends Migration
{
    public function up()
    {
        Schema::create('page_block', function(Blueprint $table){
            $table->integer('page_id', false, true)->nullable();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->integer('block_id', false, true)->nullable();
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
        });
    }

    public function down()
    {

    }
}
