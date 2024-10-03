<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // DB facade is a powerful tool in Laravel that allows you to interact with your database using a fluent query builder or raw SQL. It provides flexibility for various database operations while maintaining a clean and expressive syntax without needing to deal with Models classes.


        DB::table('users')->insert([
            // Admin
            [
            'full_name'=>'Ahmad Admin',
            'username'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('qwert@123'),
            'role'=>'admin',
            'status'=>'active'
            ],
            // Vendor
            [
            'full_name'=>'Ahmad Vendor',
            'username'=>'vendor',
            'email'=>'vendor@gmail.com',
            'password'=>Hash::make('qwert@123'),
            'role'=>'vendor',
            'status'=>'active'
            ],
            [
            'full_name'=>'Ahmad Customer',
            'username'=>'customer',
            'email'=>'customer@gmail.com',
            'password'=>Hash::make('qwert@123'),
            'role'=>'customer',
            'status'=>'active'
            ]
        ]);
    }
}
