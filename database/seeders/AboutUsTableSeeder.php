<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AboutUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('about_us')->insert(
            [
                [
                    'heading'=>'Bigshop is elegant e-commerce. It\'s suitable for all e-commerce platform',
                    'content'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione quibusdam saepe alias dignissimos consequatur ullam expedita voluptas commodi veritatis repellendus nostrum, tempore, ducimus architecto iure.',
                    'image1'=>'frontend/img/gallery/1.png',
                    'image2'=>'frontend/img/gallery/2.png',
                    'image3'=>'frontend/img/gallery/3.png',
                    'image4'=>'frontend/img/gallery/4.png',
                ]
            ]
        );
    }
}
