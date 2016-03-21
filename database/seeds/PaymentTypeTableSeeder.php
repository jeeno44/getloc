<?php

use Illuminate\Database\Seeder;

class PaymentTypeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('payment_types')->delete();
        DB::statement('ALTER TABLE payment_types AUTO_INCREMENT = 1');
        \App\PaymentType::create([
            'name'      => 'Яндекс.Касса',
            'slug'      => 'yandex.kassa',
        ]);
        \App\PaymentType::create([
            'name'      => 'Безналичный платеж',
            'slug'      => 'beznal',
        ]);
    }
}
