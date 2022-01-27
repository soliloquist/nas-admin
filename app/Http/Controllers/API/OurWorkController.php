<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Specialty;
use App\Models\Tag;
use App\Models\Work;
use App\Services\BlockService;
use App\Services\UrlService;
use Illuminate\Http\Request;

class OurWorkController extends Controller
{
    protected BlockService $service;

    public function index(Request $request)
    {
        $specialties = Specialty::orderBy('sort')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'color' => $item->color,
                'text' => $item->name,
            ];
        });

        $tags = Tag::get()->map(function ($item) {
            return [
                'id' => $item->id,
                'tag' => $item->name
            ];
        });

        $langs = Language::all();
        $zh = $langs->firstWhere('code', 'zh');
        $en = $langs->firstWhere('code', 'en');
        $jp = $langs->firstWhere('code', 'jp');

        $begin= $request->begin ?? 0;
        $end = $request->end ??  9;

        $filters = [];

        if ($request->filter) {
            foreach ($request->filter as $item) {
                $filters[] = $item['tag'];
            }
        }

        if (in_array('all', $filters)) $filters = [];

        $zhTotal = $this->getCount($zh, $filters);

        $zhItems = $this->getList($zh, $begin, $end, $filters);

        $enTotal = $this->getCount($en, $filters);

        $enItems = $this->getList($en, $begin, $end, $filters);

        $jpTotal = $this->getCount($jp, $filters);

        $jpItems = $this->getList($jp, $begin, $end, $filters);

        return response()->json(
            [
                "result" => true,
                "type" => $specialties,
                "filter" => $tags,
                'en' => [
                    'works' => $enItems,
                    'total' => $enTotal,
                ],
                'cn' => [
                    'works' => $zhItems,
                    'total' => $zhTotal,
                ],
                'jp' => [
                    'works' => $jpItems,
                    'total' => $jpTotal,
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

        $urlService = new UrlService();

        $proportion = [];
        $totalRate = 0;
        $item->specialties->each(function ($item) use (&$totalRate) {
            $totalRate += $item->pivot->percentage;
        });

        $remainder = 100;

        $item->specialties->each(function ($item) use ($totalRate, &$proportion, &$remainder) {
            if ($item->pivot->percentage) {

                $percentage = floor(($item->pivot->percentage / $totalRate) * 100);

                $proportion[] = [
                    'id' => $item->id,
                    'color' => $item->color,
                    'percentage' => $percentage
                ];
            }

            $remainder -= $percentage;
        });

        if (count($proportion)) $proportion[0]['percentage'] += $remainder;

        $banner = $item->getFirstMedia();

        $array = [];

        $next = Work::where('id', '>', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();
        $prev = Work::where('id', '<', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();

        $array['title'] = $item->title;
        $array['banner'] = $banner ? [
            'url' => $banner->getUrl('small') ? $banner->getUrl('small') : $banner->getUrl(),
            'width' => $banner->getCustomProperty('width'),
            'height' => $banner->getCustomProperty('height'),
        ] : null;
        $array['youtubeLink'] = $item->video_url;
        $array['websiteLink'] = $item->website_url;
        $array['previousPage'] = $prev ? '/ourworks/' . $prev->slug : '';
        $array['nextPage'] = $next ? '/ourworks/' . $next->slug : '';
        $array['section'] = $item->articles()->orderBy('sort')->get()->map(function ($block) {
            return [
                'id' => $block->id,
                'type' => $block->type,
                'content' => $this->service->getContent($block)
            ];
        });

        if ($item->credits->count()) {

            $credits = $item->credits()->orderBy('sort', 'asc')->get()->map(function ($c) {
                return [
                    'id' => $c->id,
                    'title' => $c->title,
                    'name' => json_decode($c->people)
                ];
            });

            $array['section']->push([
                'id' => 99999,
                'type' => 'team',
                'content' => $credits
            ]);
        }

        $array['proportion'] = $proportion;

        return $array;
    }

    private function getCount(Language $lang, $filters)
    {
        $total = Work::when($filters, function ($query, $filters) {
            return $query->whereHas('tags', function ($query) use ($filters) {
                $query->whereIn('name', $filters);
            });
        })
            ->where('language_id', $lang->id)
            ->where('enabled', 1)
            ->count();

        return $total;
    }

    private function getList(Language $lang, $begin, $end, $filters = null)
    {
        $items = Work::with('articles')
            ->when($filters, function ($query, $filters) {
                return $query->whereHas('tags', function ($query) use ($filters) {
                    $query->whereIn('name', $filters);
                });
            })
            ->where('language_id', $lang->id)
            ->where('enabled', 1)
            ->orderBy('sort', 'asc')
            ->skip($begin)
            ->take($end + 1 - $begin)
            ->get()
            ->map(function ($item) {

                $proportion = [];
                $totalRate = 0;
                $item->specialties->each(function ($item) use (&$totalRate) {
                    $totalRate += $item->pivot->percentage;
                });

                $remainder = 100;

                $item->specialties->each(function ($item) use ($totalRate, &$proportion, &$remainder) {
                    if ($item->pivot->percentage) {

                        $percentage = floor(($item->pivot->percentage / $totalRate) * 100);

                        $proportion[] = [
                            'id' => $item->id,
                            'color' => $item->color,
                            'percentage' => $percentage
                        ];
                    }

                    $remainder -= $percentage;
                });

                if (count($proportion)) $proportion[0]['percentage'] += $remainder;

                $image = $item->getFirstMedia();

                return [
                    'id' => $item->slug,
                    'title' => $item->title,
                    'proportion' => $proportion,
                    'image' => $image ? [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ] : null
                ];
            });

        return $items;
    }
}
