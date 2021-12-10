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

        $rowPerPage = 10;
        $page = $request->page ? $request->page : 1;

        $filters = [];

        if ($request->filter) {
            foreach ($request->filter as $item) {
                $filters[] = $item['tag'];
            }
        }

        if (in_array('all', $filters)) $filters = [];

        $zhTotal = Work::when($filters, function ($query, $filters) {
                return $query->whereHas('tags', function ($query) use ($filters) {
                    $query->whereIn('name', $filters);
                });
            })
            ->where('language_id', $zh->id)
            ->where('enabled', 1)
            ->count();

        $zhItems = Work::with('articles', 'tags')
            ->when($filters, function ($query, $filters) {
                return $query->whereHas('tags', function ($query) use ($filters) {
                    $query->whereIn('name', $filters);
                });
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
                    'title' => $item->title,
                    'image' => $image ? [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ] : null
                ];
            });

        $enTotal = Work::when($filters, function ($query, $filters) {
            return $query->whereHas('tags', function ($query) use ($filters) {
                $query->whereIn('name', $filters);
            });
        })
            ->where('language_id', $en->id)
            ->where('enabled', 1)
            ->count();

        $enItems = Work::with('articles')
            ->when($filters, function ($query, $filters) {
                return $query->whereHas('tags', function ($query) use ($filters) {
                    $query->whereIn('name', $filters);
                });
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
                    'title' => $item->title,
                    'image' => $image ? [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ] : null
                ];
            });

        $jpTotal = Work::when($filters, function ($query, $filters) {
            return $query->whereHas('tags', function ($query) use ($filters) {
                $query->whereIn('name', $filters);
            });
        })
            ->where('language_id', $jp->id)
            ->where('enabled', 1)
            ->count();

        $jpItems = Work::with('articles')
            ->when($filters, function ($query, $filters) {
                return $query->whereHas('tags', function ($query) use ($filters) {
                    $query->whereIn('name', $filters);
                });
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
                "filter" => $tags,
                'totalPage' => 9999,
                'en' => [
                    'works' => $enItems,
                    'totalPage' => ceil($enTotal / $rowPerPage),
                ],
                'cn' => [
                    'works' => $zhItems,
                    'totalPage' => ceil($zhTotal / $rowPerPage),
                ],
                'jp' => [
                    'works' => $jpItems,
                    'totalPage' => ceil($jpTotal / $rowPerPage),
                ],
            ]
        );
    }

    public function index2(Request $request)
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

        $zhTotal = Work::when($filters, function ($query, $filters) {
                return $query->whereHas('tags', function ($query) use ($filters) {
                    $query->whereIn('name', $filters);
                });
            })
            ->where('language_id', $zh->id)
            ->where('enabled', 1)
            ->count();

        $zhItems = Work::with('articles', 'tags')
            ->when($filters, function ($query, $filters) {
                return $query->whereHas('tags', function ($query) use ($filters) {
                    $query->whereIn('name', $filters);
                });
            })
            ->where('language_id', $zh->id)
            ->where('enabled', 1)
            ->orderBy('sort')
            ->skip($begin)
            ->take($end + 1 - $begin)
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

        $enTotal = Work::when($filters, function ($query, $filters) {
            return $query->whereHas('tags', function ($query) use ($filters) {
                $query->whereIn('name', $filters);
            });
        })
            ->where('language_id', $en->id)
            ->where('enabled', 1)
            ->count();

        $enItems = Work::with('articles')
            ->when($filters, function ($query, $filters) {
                return $query->whereHas('tags', function ($query) use ($filters) {
                    $query->whereIn('name', $filters);
                });
            })
            ->where('language_id', $en->id)
            ->where('enabled', 1)
            ->orderBy('sort')
            ->skip($begin)
            ->take($end + 1 - $begin)
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

        $jpTotal = Work::when($filters, function ($query, $filters) {
            return $query->whereHas('tags', function ($query) use ($filters) {
                $query->whereIn('name', $filters);
            });
        })
            ->where('language_id', $jp->id)
            ->where('enabled', 1)
            ->count();

        $jpItems = Work::with('articles')
            ->when($filters, function ($query, $filters) {
                return $query->whereHas('tags', function ($query) use ($filters) {
                    $query->whereIn('name', $filters);
                });
            })
            ->where('language_id', $jp->id)
            ->where('enabled', 1)
            ->orderBy('sort')
            ->skip($begin)
            ->take($end + 1 - $begin)
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

        $item->specialties->each(function ($item) use ($totalRate, &$proportion) {
            if ($item->pivot->percentage) {
                $proportion[] = [
                    'id' => $item->id,
                    'color' => $item->color,
                    'percentage' => floor(($item->pivot->percentage / $totalRate) * 100)
                ];
            }
        });

        $banner = $item->getFirstMedia();

        $array = [];

        $next = Work::where('id', '>', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();
        $prev = Work::where('id', '<', $item->id)->where('enabled', 1)->where('language_id', $lang->id)->first();

        $array['title'] = $item->title;
        $array['banner'] = $banner ? [
            'url' => $banner->getUrl(),
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

            $credits = $item->credits->map(function ($c) {
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

    private function getImage($item)
    {

    }
}
