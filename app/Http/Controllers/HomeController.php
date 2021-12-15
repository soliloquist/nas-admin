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
        $enDocDownload = Setting::where('key', 'index_en_doc_download_url')->first();
        $cnDocDownload = Setting::where('key', 'index_cn_doc_download_url')->first();
        $jpDocDownload = Setting::where('key', 'index_jp_doc_download_url')->first();
        $bannerVideo = Setting::where('key', 'index_banner_video')->first();

        return view('home.index', compact('bannerMd', 'bannerXs', 'docDownload', 'bannerVideo', 'enDocDownload', 'cnDocDownload', 'jpDocDownload'));
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

    public function enDocDownload()
    {
        $title = '英文版文件下載連結';
        $path = 'home.en-doc-download';
        return view('home.edit', compact('path', 'title'));
    }

    public function cnDocDownload()
    {
        $title = '中文版文件下載連結';
        $path = 'home.cn-doc-download';
        return view('home.edit', compact('path', 'title'));
    }

    public function jpDocDownload()
    {
        $title = '日文版文件下載連結';
        $path = 'home.jp-doc-download';
        return view('home.edit', compact('path', 'title'));
    }

    public function edit($key)
    {
        $title = 'EDIT';
        return view('home.edit', compact('key', 'title'));
    }
}
