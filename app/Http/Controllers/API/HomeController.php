<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Work;

class HomeController extends Controller
{
    public function __invoke()
    {
        $setting = Setting::all();

        $bannerXS = $setting->firstWhere('key','index_banner_xs');
        $bannerXSMedia = $bannerXS->getFirstMedia();
        $bannerXSArray =

        $bannerMD = $setting->firstWhere('key','index_banner_md');
        $bannerMDMedia = $bannerMD->getFirstMedia();

        $downloadUrl = $setting->firstWhere('key','index_doc_download_url');

        $lang = Language::get();
        $zh = $lang->firstWhere('code', 'zh');
        $en = $lang->firstWhere('code', 'en');
        $jp = $lang->firstWhere('code', 'jp');

        $zhWorks = Work::where('language_id', $zh->id)->take(10)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'image' => [
                    'url' => $item->getFirstMediaUrl(),
                    'width' => $item->getFirstMedia()->getCustomProperty('width'),
                    'height' => $item->getFirstMedia()->getCustomProperty('height'),
                ]
            ];
        });

        $enWorks = Work::where('language_id', $en->id)->take(10)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'image' => [
                    'url' => $item->getFirstMediaUrl(),
                    'width' => $item->getFirstMedia()->getCustomProperty('width'),
                    'height' => $item->getFirstMedia()->getCustomProperty('height'),
                ]
            ];
        });

        $jpWorks = Work::where('language_id', $jp->id)->take(10)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'image' => [
                    'url' => $item->getFirstMediaUrl(),
                    'width' => $item->getFirstMedia()->getCustomProperty('width'),
                    'height' => $item->getFirstMedia()->getCustomProperty('height'),
                ]
            ];
        });

        return response()->json([
            "result" => true,
            "bannerXS" => $bannerMDMedia ? [
                "url" => $bannerXSMedia->getUrl(),
                "width" => $bannerXSMedia->getCustomProperty('width'),
                "height" => $bannerXSMedia->getCustomProperty('height'),
            ] : null,
            "bannerMD" => $bannerMDMedia ? [
                "url" => $bannerMDMedia->getUrl(),
                "width" => $bannerMDMedia->getCustomProperty('width'),
                "height" => $bannerMDMedia->getCustomProperty('height'),
            ] : null,
            "downloadUrl" => $downloadUrl->value,
            "en" => [
                "list" => $enWorks
            ],
            "cn" => [
                "list" => $zhWorks
            ],
            "jp" => [
                "list" => $jpWorks
            ],
        ]);
    }
}
