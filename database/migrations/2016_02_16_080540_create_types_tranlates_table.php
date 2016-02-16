<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTranlatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types_translates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        $types = [
            ['name' => 'Машинный'],
            ['name' => 'Ручной'],
            ['name' => 'Профессиональный'],
        ];
        foreach ($types as $type) {
            DB::table('types_translates')->insert($type);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('types_translates');
    }
}
