<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->string('company_post_address', 500);
            $table->string('company_law_address', 500);
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
        Schema::drop('user_details');
    }
}
