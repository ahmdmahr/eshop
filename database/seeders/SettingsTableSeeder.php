<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert(
            [
                [
                    'title'=>'Eshop.io',
                    'meta_description'=>'echop online ecommerce fighting with amzaon',
                    'meta_keywords'=>'Eshop,Online Shopping,Ecommerce Website',
                    'logo'=>'frontend/img/core-img/logo.png',
                    'favicon'=>'frontend/img/core-img/icon.jpg',
                    'email'=>'info@eshop.io',
                    'phone'=>'+987654321',
                    'address'=>'cairo,egypt',
                    'fax'=>'802 9803 845309',
                    'footer'=>'Ahmad Maher',
                    'facebook'=>'',
                    'twitter'=>'',
                    'linkedin'=>'',
                    'pinterest'=>''
                ]
            ]
        );
    }
}
