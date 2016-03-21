<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('payments');
        Schema::create('payments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->nullable();
            $table->integer('payment_type_id', false, true)->nullable()->index();
            $table->decimal('sum');
            $table->string('relation');
            $table->integer('outer_id', false, true)->nullable();
            $table->integer('coupon_id', false, true)->nullable();
            $table->enum('status', ['new', 'confirmed', 'canceled'])->default('new');
            $table->timestamps();
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
