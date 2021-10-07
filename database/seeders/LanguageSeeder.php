<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        \DB::table('languages')->insert([
            [
                'code' => 'zh',
                'label' => '繁體中文',
            ],
            [
                'code' => 'en',
                'label' => 'English',
            ],
            [
                'code' => 'jp',
                'label' => '日本語'
            ]
        ]);
    }
}
