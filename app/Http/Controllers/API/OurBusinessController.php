<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Business;
use App\Models\Language;
use App\Services\BlockService;
use App\Services\UrlService;
use Illuminate\Http\Request;

class OurBusinessController extends Controller
{
    protected BlockService $service;

    public function index(Request $request)
    {
        $rowPerPage = 10;
        $page = $request->page ? $request->page : 1;

        $langs = Language::all();
        $zh = $langs->firstWhere('code', 'zh');
        $en = $langs->firstWhere('code', 'en');
        $jp = $langs->firstWhere('code', 'jp');

        $zhItems = Business::with('articles')
            ->where('language_id', $zh->id)
            ->where('enabled', 1)
            ->orderBy('sort')
            ->skip(($page - 1) * $rowPerPage)
            ->take($rowPerPage)
            ->get()
            ->map(function ($item) {
                $image = $item->getFirstMedia();
                return [
                    'id' => $item->slug,
                    'title' => $item->title,
                    'image' => $image ? [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ] : null
                ];
            });

        $enItems = Business::with('articles')
            ->where('language_id', $en->id)
            ->where('enabled', 1)
            ->orderBy('sort')
            ->skip(($page - 1) * $rowPerPage)
            ->take($rowPerPage)
            ->get()
            ->map(function ($item) {
                $image = $item->getFirstMedia();
                return [
                    'id' => $item->slug,
                    'title' => $item->title,
                    'image' => $image ? [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ] : null
                ];
            });

        $jpItems = Business::with('articles')
            ->where('language_id', $en->id)
            ->where('enabled', 1)
            ->orderBy('sort')
            ->skip(($page - 1) * $rowPerPage)
            ->take($rowPerPage)
            ->get()
            ->map(function ($item) {
                $image = $item->getFirstMedia();
                return [
                    'id' => $item->slug,
                    'title' => $item->title,
                    'image' => $image ? [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ] : null
                ];
            });

        return response()->json(
            [
                "result" => true,
                'en' => [
                    'list' => $enItems
                ],
                'cn' => [
                    'list' => $zhItems
                ],
                'jp' => [
                    'list' => $jpItems
                ],
            ]
        );
    }

    public function show(Request $request, $slug)
    {
        $this->service = new BlockService();

        $langs = Language::all();
        $zh = $langs->firstWhere('code', 'zh');
        $en = $langs->firstWhere('code', 'en');
        $jp = $langs->firstWhere('code', 'jp');

        $itemZh = Business::where('language_id', $zh->id)->where('enabled', 1)->where('slug', $slug)->with('articles')->first();
        $itemEn = Business::where('language_id', $en->id)->where('enabled', 1)->where('slug', $slug)->with('articles')->first();
        $itemJp = Business::where('language_id', $jp->id)->where('enabled', 1)->where('slug', $slug)->with('articles')->first();

        return response()->json([
            'result' => true,
            'en' => $this->getResult($itemEn, $en),
            'cn' => $this->getResult($itemZh, $zh),
            'jp' => $this->getResult($itemJp, $jp),
        ]);
    }

    private function getResult(Business $item = null, $lang)
    {
        if (!$item) return [];

        $urlService = new UrlService();

        $array = [];

        $banner = $item->getFirstMedia();

        $next = Business::where('id', '>', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();
        $prev = Business::where('id', '<', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();

        $array['title'] = $item->title;
        $array['banner'] = $banner ? [
            'url' => $banner->getUrl(),
            'width' => $banner->getCustomProperty('width'),
            'height' => $banner->getCustomProperty('height'),
        ] : null;
        $array['youtubeLink'] = $urlService->getYoutubeIdFromUrl($item->video_url);
        $array['websiteLink'] = $item->website_url;
        $array['previousPage'] = $prev ? '/ourbusiness/' . $prev->slug : '';
        $array['nextPage'] = $next ? '/ourbusiness/' . $next->slug : '';
        $array['section'] = $item->articles->map(function ($block) {
            return [
                'id' => $block->id,
                'type' => $block->type,
                'content' => $this->service->getContent($block)
            ];
        });

        return $array;
    }
}
