<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('key');
            $table->text('val');
            $table->timestamps();
        });
        DB::table('options')->insert([
            'name'      => 'Список стоп-ресурсов',
            'key'       => 'stop_words',
            'val'       => ''
        ]);
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
