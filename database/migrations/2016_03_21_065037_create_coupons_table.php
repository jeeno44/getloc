<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->nullable()->index();
            $table->integer('site_id', false, true)->nullable()->index();
            $table->string('code')->unique();
            $table->integer('discount');
            $table->boolean('is_percent');
            $table->enum('type', ['once', 'fixed', 'unlimited'])->default('once');
            $table->timestamp('ends_at');
            $table->timestamp('activated_at');
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('coupons');
    }
}
