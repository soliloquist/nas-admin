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

        $langs = Language::all();
        $zh = $langs->firstWhere('code', 'zh');
        $en = $langs->firstWhere('code', 'en');
        $jp = $langs->firstWhere('code', 'jp');

        $rowPerPage = 10;
        $page = $request->page ? $request->page : 1;

        $year = $request->year;

        $zhYears = Update::where('language_id', $zh->id)->where('enabled', 1)->select('year')->orderBy('year', 'desc')->groupBy('year')->get();
        $zhYearsArray = [];

        for ($i = 0; $i < $zhYears->count(); $i++) {
            $zhYearsArray[] = [
                'id' => $i + 1,
                'text' => substr($zhYears[$i]['year'], 0, 4)
            ];
        }

        $zhTotalPages = Update::when($year, function ($query, $year) {
            return $query->whereYear('year', $year);
        })
            ->where('language_id', $zh->id)
            ->where('enabled', 1)
            ->count();

        $zhItems = Update::with('articles')
            ->when($year, function ($query, $year) {
                return $query->whereYear('year', $year);
            })
            ->where('language_id', $zh->id)
            ->where('enabled', 1)
            ->orderBy('date', 'desc')
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

        $enYears = Update::where('language_id', $en->id)->where('enabled', 1)->select('year')->orderBy('year', 'desc')->groupBy('year')->get();
        $enYearsArray = [];

        for ($i = 0; $i < $enYears->count(); $i++) {
            $enYearsArray[] = [
                'id' => $i + 1,
                'text' => substr($enYears[$i]['year'], 0, 4)
            ];
        }

        $enTotalPages = Update::when($year, function ($query, $year) {
            return $query->whereYear('year', $year);
        })
            ->where('language_id', $en->id)
            ->where('enabled', 1)
            ->count();

        $enItems = Update::with('articles')
            ->when($year, function ($query, $year) {
                return $query->whereYear('year', $year);
            })
            ->where('language_id', $en->id)
            ->where('enabled', 1)
            ->orderBy('date', 'desc')
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


        $jpYears = Update::where('language_id', $jp->id)->where('enabled', 1)->select('year')->orderBy('year', 'desc')->groupBy('year')->get();
        $jpYearsArray = [];

        for ($i = 0; $i < $jpYears->count(); $i++) {
            $jpYearsArray[] = [
                'id' => $i + 1,
                'text' => substr($jpYears[$i]['year'], 0, 4)
            ];
        }

        $jpTotalPages = Update::when($year, function ($query, $year) {
            return $query->whereYear('year', $year);
        })
            ->where('language_id', $jp->id)
            ->where('enabled', 1)
            ->count();

        $jpItems = Update::with('articles')
            ->when($year, function ($query, $year) {
                return $query->whereYear('year', $year);
            })
            ->where('language_id', $jp->id)
            ->where('enabled', 1)
            ->orderBy('date', 'desc')
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
            'year' => [],
            'en' => [
                'year' => $enYearsArray,
                'list' => $enItems,
                'totalPage' => ceil($enTotalPages / $rowPerPage),
            ],
            'cn' => [
                'year' => $zhYearsArray,
                'list' => $zhItems,
                'totalPage' => ceil($zhTotalPages / $rowPerPage),
            ],
            'jp' => [
                'year' => $jpYearsArray,
                'list' => $jpItems,
                'totalPage' => ceil($jpTotalPages / $rowPerPage),
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

        $next = Update::where('id', '>', $item->id)->where('enabled', 1)->orderBy('sort', 'asc')->where('language_id', $lang->id)->first();
        $prev = Update::where('id', '<', $item->id)->where('enabled', 1)->orderBy('sort', 'asc')->where('language_id', $lang->id)->first();

        $banner = $item->getFirstMedia();

        $array['title'] = $item->title;
        $array['banner'] = $banner ? [
            'url' => $banner->hasGeneratedConversion('small') ? $banner->getUrl('small') : $banner->getUrl(),
            'width' => $banner->getCustomProperty('width'),
            'height' => $banner->getCustomProperty('height'),
        ] : null;
        $array['youtubeLink'] = $item->video_url;
        $array['websiteLink'] = $item->website_url;
        $array['previousPage'] = $prev ? '/ourupdates/' . $prev->slug : '';
        $array['nextPage'] = $next ? '/ourupdates/' . $next->slug : '';
        $array['section'] = $item->articles()->orderBy('sort')->get()->map(function ($block) {
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
