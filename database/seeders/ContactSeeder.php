<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run()
    {
        \DB::table('contacts')->insert([
            [
                'contact_type_id' => 1,
                'email' => 'test1@email.com'
            ],
            [
                'contact_type_id' => 2,
                'email' => 'test2@email.com'
            ],
            [
                'contact_type_id' => 1,
                'email' => 'test3@email.com'
            ],
        ]);
    }
}
