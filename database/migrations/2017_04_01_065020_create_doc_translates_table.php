<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('docs_sites', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::create('doc_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id', false, true)->nullable()->index();;
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->integer('doc_id', false, true)->nullable()->index();;
            $table->foreign('doc_id')->references('id')->on('docs_sites')->onDelete('cascade');
            $table->integer('language_id', false, true)->nullable()->index();;
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('full_url', 500);
            $table->string('ftype', 20);
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
        Schema::drop('doc_translates');
    }
}
