<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run()
    {
        \DB::table('contacts')->insert([
            [
                'email' => 'test1@email.com'
            ],
            [
                'email' => 'test2@email.com'
            ],
            [
                'email' => 'test3@email.com'
            ],
        ]);
    }
}
