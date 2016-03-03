<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('desc');
            $table->decimal('cost');
            $table->decimal('old_cost');
            $table->string('period_name')->default('month');
            $table->tinyInteger('period_value')->default(1);
            $table->integer('count_words');
            $table->integer('count_languages');
            $table->boolean('white_label')->default(true);
            $table->boolean('enabled')->default(true);
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
        //
    }
}
