<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Work;
use App\Services\UrlService;

class HomeController extends Controller
{
    public function __invoke()
    {
        $setting = Setting::all();

        $bannerXS = $setting->firstWhere('key','index_banner_xs');
        $bannerXSMedia = $bannerXS->getFirstMedia();

        $bannerMD = $setting->firstWhere('key','index_banner_md');
        $bannerMDMedia = $bannerMD->getFirstMedia();

        $downloadUrl = $setting->firstWhere('key','index_doc_download_url');

        $video = $setting->firstWhere('key', 'index_banner_video');
        $videoImage = $video->getFirstMedia();

        $lang = Language::get();
        $zh = $lang->firstWhere('code', 'zh');
        $en = $lang->firstWhere('code', 'en');
        $jp = $lang->firstWhere('code', 'jp');

        $zhWorks = Work::where('language_id', $zh->id)->where('enabled', 1)->orderBy('sort')->take(10)->get()->map(function($item) {
            $image = $item->getFirstMedia('thumbnail');

            $imageUrl = null;

            if (!$image) {
                $image = $item->getFirstMedia();

                if ($image) {
                    if ($image->getUrl('thumbnail')) {
                        $imageUrl = $image->getUrl('thumbnail');
                    } else {
                        $imageUrl = $image->getUrl();
                    }
                }

            } else {
                $imageUrl = $image->getUrl('thumbnail');
            }

            return [
                'id' => $item->slug,
                'title' => $item->title,
                'image' => $imageUrl ? [
                    'url' => $imageUrl,
                    'width' => 600,
                    'height' => 600,
                ]: null
            ];
        });

        $enWorks = Work::where('language_id', $en->id)->where('enabled', 1)->orderBy('sort')->take(10)->get()->map(function($item) {
            $image = $item->getFirstMedia('thumbnail');

            $imageUrl = null;

            if (!$image) {
                $image = $item->getFirstMedia();

                if ($image) {
                    if ($image->getUrl('thumbnail')) {
                        $imageUrl = $image->getUrl('thumbnail');
                    } else {
                        $imageUrl = $image->getUrl();
                    }
                }

            } else {
                $imageUrl = $image->getUrl('thumbnail');
            }

            return [
                'id' => $item->slug,
                'title' => $item->title,
                'image' => $imageUrl ? [
                    'url' => $imageUrl,
                    'width' => 600,
                    'height' => 600,
                ]: null
            ];
        });

        $jpWorks = Work::where('language_id', $jp->id)->where('enabled', 1)->orderBy('sort')->take(10)->get()->map(function($item) {
            $image = $item->getFirstMedia('thumbnail');

            $imageUrl = null;

            if (!$image) {
                $image = $item->getFirstMedia();

                if ($image) {
                    if ($image->getUrl('thumbnail')) {
                        $imageUrl = $image->getUrl('thumbnail');
                    } else {
                        $imageUrl = $image->getUrl();
                    }
                }

            } else {
                $imageUrl = $image->getUrl('thumbnail');
            }

            return [
                'id' => $item->slug,
                'title' => $item->title,
                'image' => $imageUrl ? [
                    'url' => $imageUrl,
                    'width' => 600,
                    'height' => 600,
                ]: null
            ];
        });

        $urlService = new UrlService();

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
            'video' => [
                'url' => $urlService->getYoutubeIdFromUrl($video->value),
                'image' => $videoImage ? [
                    'url' => $videoImage->getUrl(),
                    'width' => $videoImage->getCustomProperty('width'),
                    'height' => $videoImage->getCustomProperty('height'),
                ] : null
            ],
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
