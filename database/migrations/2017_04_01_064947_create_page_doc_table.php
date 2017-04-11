<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageDocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_doc', function (Blueprint $table) {
            $table->integer('page_id', false, true)->nullable()->index();;
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->integer('doc_id', false, true)->nullable()->index();;
            $table->foreign('doc_id')->references('id')->on('docs_sites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_doc', function (Blueprint $table) {
            //
        });
    }
}
