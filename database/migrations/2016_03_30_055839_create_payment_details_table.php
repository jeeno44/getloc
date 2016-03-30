<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_id', false, true)->nullable()->index();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->string('post_address', 500);
            $table->string('law_address', 500);
            $table->string('company_name');
            $table->string('company_bank_account');
            $table->string('company_bank_bik');
            $table->string('company_ogrn');
            $table->string('company_principal_post');
            $table->string('company_principal_name');
            $table->string('company_file');
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
        Schema::drop('payment_details');
    }
}
