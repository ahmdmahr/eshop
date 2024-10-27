<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currencies')->insert(
            [
                [
                    'name'=>'USA Dollar',
                    'symbol'=>'$',
                    'exchange_rate'=>1,
                    'code'=>'USD'
                ],
                [
                    'name'=>'Egyption pound',
                    'symbol'=>'£',
                    'exchange_rate'=>50,
                    'code'=>'EGP'
                ]
            ]
        );
    }
}
