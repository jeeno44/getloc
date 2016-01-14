<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 100);
            $table->string('short', 10);
        });
        DB::statement(file_get_contents(public_path('languages.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_language');
        Schema::dropIfExists('translates');
        Schema::dropIfExists('languages');
    }
}
