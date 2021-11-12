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
        $path = 'home.banner-md';
        return view('home.edit', compact('path'));
    }

    public function bannerXs()
    {
        $path = 'home.banner-xs';
        return view('home.edit', compact('path'));
    }

    public function bannerVideo()
    {
        $path = 'home.banner-video';
        return view('home.edit', compact('path'));
    }

    public function bannerVideoCover()
    {
        $path = 'home.banner-video-cover';
        return view('home.edit', compact('path'));
    }

    public function docDownload()
    {
        $path = 'home.doc-download';
        return view('home.edit', compact('path'));
    }

    public function edit($key)
    {
        return view('home.edit', compact('key'));
    }
}
