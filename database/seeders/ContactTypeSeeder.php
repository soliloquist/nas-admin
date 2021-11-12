<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    public function run()
    {
        \DB::table('contact_types')->insert([
            [
                'title' => '合作提案',
            ],
            [
                'title' => '客戶服務',
            ],
        ]);
    }
}
