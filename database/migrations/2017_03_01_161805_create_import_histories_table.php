<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->unsigned()->index();
            $table->integer('from_language_id')->unsigned()->index();
            $table->integer('to_language_id')->unsigned()->index();
            $table->string('file_name');
            $table->string('file_path');
            $table->integer('count_blocks');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->foreign('from_language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('to_language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::table('sites', function (Blueprint $table) {
            $table->timestamp('demo_ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('import_histories');
    }
}
