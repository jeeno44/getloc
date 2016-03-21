<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('subscriptions')->delete();
        Schema::table('subscriptions', function(Blueprint $table) {
            $table->boolean('white_label');
            $table->integer('count_languages', false, true);
            $table->integer('site_id', false, true)->nullable();
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
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
