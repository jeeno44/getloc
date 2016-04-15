<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryChangesPhrasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_changes_phrases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('translate_id')->unsigned()->index();
            $table->text('text');
//	        $table->foreign('translate_id')->references('id')->on('translates');
	        $table->foreign('translate_id')
		        ->references('id')->on('translates')
		        ->onDelete('cascade');
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
        Schema::drop('history_changes_phrases');
    }
}
