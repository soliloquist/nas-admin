<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Business;
use App\Models\Language;
use App\Services\BlockService;
use Illuminate\Http\Request;

class OurBusinessController extends Controller
{
    protected BlockService $service;

    public function index()
    {
        // TODO 前端 api 需修改，加入語系判斷
        $langCode = 'zh';

        $lang = Language::firstWhere('code', $langCode);
        $businesses = Business::where('language_id', $lang->id)
            ->where('enabled', 1)
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->slug,
                    'title' => $item->title,
                    'image' => $item->getFirstMediaUrl()
                ];
            });
        return response()->json([
            'result' => true,
            'list' => $businesses,
        ]);
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

        $array = [];

        $next = Business::where('id', '>', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();
        $prev = Business::where('id', '<', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();

        $array['title'] = $item->title;
        $array['banner'] = $item->getFirstMediaUrl();
        $array['youtubeLink'] = $item->video_url;
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
