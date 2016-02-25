<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('visibility_name')->after('email');
            $table->string('phone')->after('visibility_name');
            $table->string('site')->after('phone');
            $table->string('company')->after('site');
            $table->string('partner_link')->after('company');
            $table->string('partner_id')->after('partner_link');
            $table->decimal('partner_income')->after('partner_id');
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
