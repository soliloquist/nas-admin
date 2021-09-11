<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        \DB::table('users')->insert(
            [
                [
                    'name' => 'fang',
                    'email' => 'fang@unus.com.tw',
                    'password' => Hash::make('111111')
                ],
                [
                    'name' => 'admin',
                    'email' => 'admin@nextanimationstudio.com',
                    'password' => Hash::make('7Ks"F5\d<wuA6%N3')
                ],
            ]
        );
    }
}
