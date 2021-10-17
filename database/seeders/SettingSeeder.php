<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        \DB::table('settings')->insert([
            [
                'key' => 'index_banner_xs',
                'value' => null
            ],
            [
                'key' => 'index_banner_md',
                'value' => null
            ],
            [
                'key' => 'index_doc_download_url',
                'value' => null
            ],
            [
                'key' => 'vision_intro_en',
                'value' => null
            ],
            [
                'key' => 'vision_intro_cn',
                'value' => null
            ],
            [
                'key' => 'vision_intro_jp',
                'value' => null
            ],
            [
                'key' => 'vision_video_url',
                'value' => null
            ],
        ]);
    }
}
