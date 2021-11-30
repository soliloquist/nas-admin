<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $bannerMd = Setting::where('key', 'index_banner_md')->first();
        $bannerXs = Setting::where('key', 'index_banner_xs')->first();
        $docDownload = Setting::where('key', 'index_doc_download_url')->first();
        $bannerVideo = Setting::where('key', 'index_banner_video')->first();

        return view('home.index', compact('bannerMd', 'bannerXs', 'docDownload', 'bannerVideo'));
    }

    public function bannerMd()
    {
        $title = '桌機版 Image Banner';
        $path = 'home.banner-md';
        return view('home.edit', compact('path', 'title'));
    }

    public function bannerXs()
    {
        $title = '手機版 Image Banner';
        $path = 'home.banner-xs';
        return view('home.edit', compact('path', 'title'));
    }

    public function bannerVideo()
    {
        $title = '桌機版 Video Banner 影片網址';
        $path = 'home.banner-video';
        return view('home.edit', compact('path', 'title'));
    }

    public function bannerVideoCover()
    {
        $title = '桌機版 Video Banner 影片替代圖';
        $path = 'home.banner-video-cover';
        return view('home.edit', compact('path', 'title'));
    }

    public function docDownload()
    {
        $title = '文件下載連結';
        $path = 'home.doc-download';
        return view('home.edit', compact('path', 'title'));
    }

    public function edit($key)
    {
        $title = 'EDIT';
        return view('home.edit', compact('key', 'title'));
    }
}
