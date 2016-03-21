<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name'              => 'Ясли',
                'cost'              => 300,
                'count_words'       => 1000,
                'count_languages'   => 3,
            ],
            [
                'name'              => 'Садик',
                'cost'              => 1500,
                'count_words'       => 8000,
                'count_languages'   => 5,
            ],
            [
                'name'              => 'Школа',
                'cost'              => 6750,
                'count_words'       => 50000,
                'count_languages'   => 10,
            ],
            [
                'name'              => 'Универ',
                'cost'              => 23625,
                'count_words'       => 100000,
                'count_languages'   => 20,
            ],
            [
                'name'              => 'Бизнес',
                'cost'              => 70875,
                'count_words'       => 10000000,
                'count_languages'   => 100,
            ],
            [
                'name'              => 'Индивидуальный',
                'cost'              => 0,
                'count_words'       => 0,
                'count_languages'   => 0,
            ],
        ];
        DB::table('plans')->delete();
        DB::statement('ALTER TABLE plans AUTO_INCREMENT = 1');
        foreach($plans as $plan) {
            \App\Plan::create($plan);
        }
    }
}
