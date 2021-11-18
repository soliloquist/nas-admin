<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Update;
use App\Services\BlockService;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    protected BlockService $service;

    public function index(Request $request)
    {
        // 取文章年份列表

        $years = Update::select('year')->groupBy('year')->get();

        $yearsArray = [];

        for ($i = 0; $i < $years->count(); $i++) {
            $yearsArray[] = [
                'id' => $i + 1,
                'text' => substr($years[$i]['year'], 0, 4)
            ];
        }

        // END 取文章年份列表

        $langs = Language::all();
        $zh = $langs->firstWhere('code', 'zh');
        $en = $langs->firstWhere('code', 'en');
        $jp = $langs->firstWhere('code', 'jp');

        $rowPerPage = 10;
        $page = $request->page ? $request->page : 1;

        $zhItems = Update::with('articles')
            ->when($request->year, function ($query, $request) {
                return $query->whereYear('year', $request->year);
            })
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
                    'date' => [
                        'year' => $item->date->format('Y'),
                        'month' => $item->date->format('m'),
                        'date' => $item->date->format('d'),
                    ],
                    'title' => $item->title,
                    'image' => $image ? [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ] : null
                ];
            });

        $enItems = Update::with('articles')
            ->when($request->year, function ($query, $request) {
                return $query->whereYear('year', $request->year);
            })
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
                    'date' => [
                        'year' => $item->date->format('Y'),
                        'month' => $item->date->format('m'),
                        'date' => $item->date->format('d'),
                    ],
                    'title' => $item->title,
                    'image' => $image ? [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ] : null
                ];
            });

        $jpItems = Update::with('articles')
            ->when($request->year, function ($query, $request) {
                return $query->whereYear('year', $request->year);
            })
            ->where('language_id', $jp->id)
            ->where('enabled', 1)
            ->orderBy('sort')
            ->skip(($page - 1) * $rowPerPage)
            ->take($rowPerPage)
            ->get()
            ->map(function ($item) {
                $image = $item->getFirstMedia();
                return [
                    'id' => $item->slug,
                    'date' => [
                        'year' => $item->date->format('Y'),
                        'month' => $item->date->format('m'),
                        'date' => $item->date->format('d'),
                    ],
                    'title' => $item->title,
                    'image' => $image ? [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ] : null
                ];
            });

        return response()->json([
            'result' => true,
            'totalPage' => 9999,
            'year' => $yearsArray,
            'en' => [
                'list' => $enItems
            ],
            'cn' => [
                'list' => $zhItems
            ],
            'jp' => [
                'list' => $jpItems
            ],
        ]);
    }


    public function show(Request $request, $slug)
    {
        $this->service = new BlockService();

        $langs = Language::all();
        $zh = $langs->firstWhere('code', 'zh');
        $en = $langs->firstWhere('code', 'en');
        $jp = $langs->firstWhere('code', 'jp');

        $itemZh = Update::where('language_id', $zh->id)->where('enabled', 1)->where('slug', $slug)->with('articles')->first();
        $itemEn = Update::where('language_id', $en->id)->where('enabled', 1)->where('slug', $slug)->with('articles')->first();
        $itemJp = Update::where('language_id', $jp->id)->where('enabled', 1)->where('slug', $slug)->with('articles')->first();

        return response()->json([
            'result' => true,
            'en' => $this->getResult($itemEn, $en),
            'cn' => $this->getResult($itemZh, $zh),
            'jp' => $this->getResult($itemJp, $jp),
        ]);
    }

    private function getResult(Update $item = null, $lang)
    {
        if (!$item) return [];

        $array = [];

        $next = Update::where('id', '>', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();
        $prev = Update::where('id', '<', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();

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

    public function update(Request $request, Update $update)
    {
        //
    }

    public function destroy(Update $update)
    {
        //
    }
}
