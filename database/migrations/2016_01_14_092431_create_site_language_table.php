<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_language', function(Blueprint $table){
            $table->integer('site_id', false, true)->nullable()->index();;
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->integer('language_id', false, true)->nullable()->index();;
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
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
    }
}
