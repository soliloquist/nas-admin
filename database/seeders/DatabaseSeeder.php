<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            LanguageSeeder::class,
            SettingSeeder::class,
            SpecialtySeeder::class,
            ContactTypeSeeder::class,
            ContactSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
