<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    public function run()
    {
        \DB::table('specialties')->insert([
            [
                'name' => 'Art',
                'color' => '#9114f6'
            ],
            [
                'name' => 'Animation',
                'color' => '#560dfa'
            ],
            [
                'name' => 'Model',
                'color' => '#55a7ff'
            ],
        ]);
    }
}
