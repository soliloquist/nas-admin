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
        $title = '英文版 intro';
        $path = 'vision.intro-en';
        return view('vision.edit', compact('path', 'title'));
    }

    public function introCn()
    {
        $title = '中文版 intro';
        $path = 'vision.intro-cn';
        return view('vision.edit', compact('path', 'title'));
    }

    public function introJp()
    {
        $title = '日文版 intro';
        $path = 'vision.intro-jp';
        return view('vision.edit', compact('path', 'title'));
    }

    public function video()
    {
        $title = '影片連結';
        $path = 'vision.video';
        return view('vision.edit', compact('path', 'title'));
    }

    public function videoCover()
    {
        $title = '影片替代圖片';
        $path = 'vision.video-cover';
        return view('vision.edit', compact('path', 'title'));
    }
}
