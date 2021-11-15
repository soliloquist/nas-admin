<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Specialty;
use App\Models\Work;
use App\Services\BlockService;
use Illuminate\Http\Request;

class OurWorkController extends Controller
{
    protected BlockService $service;

    public function index(Request $request)
    {
        $specialties = Specialty::get()->map(function ($item) {
            return [
                'id' => $item->id,
                'color' => $item->color,
                'text' => $item->name,
            ];
        });

        $langs = Language::all();
        $zh = $langs->firstWhere('code', 'zh');
        $en = $langs->firstWhere('code', 'en');
        $jp = $langs->firstWhere('code', 'jp');

//        $types = $request->type ?  explode(',', $request->type) : null;
        $filters = $request->filters;


//        if ( $types ) {
//            $filters = Specialty::whereIn('name', $types)->get()->map(function($item) {
//               return [
//                   'id' => $item->id,
//                   'tag' => $item->name,
//               ];
//            });
//        }

        $zhItems = Work::with('articles')
//            ->when($types, function ($query, $types) {
//                return $query->whereHas('specialties', function ($query) use ($types) {
//                   $query->whereIn('name', $types);
//                });
//            })
            ->where('language_id', $zh->id)
            ->where('enabled', 1)
            ->take(10)
            ->get()
            ->map(function($item) {
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

        $enItems = Work::with('articles')
//            ->when($types, function ($query, $types) {
//                return $query->whereHas('specialties', function ($query) use ($types) {
//                    $query->whereIn('name', $types);
//                });
//            })
            ->where('language_id', $en->id)
            ->where('enabled', 1)
            ->take(10)
            ->get()
            ->map(function($item) {
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

        $jpItems = Work::with('articles')
//            ->when($types, function ($query, $types) {
//                return $query->whereHas('specialties', function ($query) use ($types) {
//                    $query->whereIn('name', $types);
//                });
//            })
            ->where('language_id', $jp->id)
            ->where('enabled', 1)
            ->take(10)
            ->get()
            ->map(function($item) {
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
                "type" => $specialties,
                "filter" => [],
                'en' => [
                    'works' => $enItems
                ],
                'cn' => [
                    'works' => $zhItems
                ],
                'jp' => [
                    'works' => $jpItems
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

        $itemZh = Work::where('language_id', $zh->id)->where('enabled', 1)->where('slug', $slug)->with('articles')->first();
        $itemEn = Work::where('language_id', $en->id)->where('enabled', 1)->where('slug', $slug)->with('articles')->first();
        $itemJp = Work::where('language_id', $jp->id)->where('enabled', 1)->where('slug', $slug)->with('articles')->first();

        return response()->json([
            'result' => true,
            'en' => $this->getResult($itemEn, $en),
            'cn' => $this->getResult($itemZh, $zh),
            'jp' => $this->getResult($itemJp, $jp),
        ]);
    }
    private function getResult(Work $item = null, $lang)
    {
        if (!$item) return [];

        $proportion = [];
        $totalRate = 0;
        $item->specialties->each(function ($item) use (&$totalRate) {
            $totalRate += $item->pivot->percentage;
        });

        $item->specialties->each(function ($item) use ($totalRate, &$proportion) {
            $proportion[] = [
                'id' => $item->id,
                'color' => $item->color,
                'percentage' => floor(($item->pivot->percentage / $totalRate) * 100)
            ];
        });

        $array = [];

        $next = Work::where('id', '>', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();
        $prev = Work::where('id', '<', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();

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
        $array['proportion'] = $proportion;

        return $array;
    }
}
