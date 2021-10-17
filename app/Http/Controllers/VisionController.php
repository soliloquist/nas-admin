<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class VisionController extends Controller
{
    public function index()
    {
        $introEn = Setting::where('key', 'vision_intro_en')->first();
        $introCn = Setting::where('key', 'vision_intro_cn')->first();
        $introJp = Setting::where('key', 'vision_intro_jp')->first();
        $video = Setting::where('key', 'vision_video_url')->first();

        return view('vision.index', compact('introCn', 'introEn', 'introJp', 'video'));
    }

    public function introEn()
    {
        $path = 'vision.intro-en';
        return view('vision.edit', compact('path'));
    }

    public function introCn()
    {
        $path = 'vision.intro-cn';
        return view('vision.edit', compact('path'));
    }

    public function introJp()
    {
        $path = 'vision.intro-jp';
        return view('vision.edit', compact('path'));
    }

    public function video()
    {
        $path = 'vision.video';
        return view('vision.edit', compact('path'));
    }
}
