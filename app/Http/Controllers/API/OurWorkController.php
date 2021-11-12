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

        $types = $request->type ?  explode(',', $request->type) : null;

        $filters = [];

        if ( $types ) {
            $filters = Specialty::whereIn('name', $types)->get()->map(function($item) {
               return [
                   'id' => $item->id,
                   'tag' => $item->name,
               ];
            });
        }

        $zhItems = Work::with('articles')
            ->when($types, function ($query, $types) {
                return $query->whereHas('specialties', function ($query) use ($types) {
                   $query->whereIn('name', $types);
                });
            })
            ->where('language_id', $zh->id)
            ->where('enabled', 1)
            ->take(10)
            ->get()
            ->map(function($item) {
                $image = $item->getFirstMedia();
                return [
                    'id' => $item->slug,
                    'title' => $item->title,
                    'image' => [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ]
                ];
            });

        $enItems = Work::with('articles')
            ->when($types, function ($query, $types) {
                return $query->whereHas('specialties', function ($query) use ($types) {
                    $query->whereIn('name', $types);
                });
            })
            ->where('language_id', $en->id)
            ->where('enabled', 1)
            ->take(10)
            ->get()
            ->map(function($item) {
                $image = $item->getFirstMedia();
                return [
                    'id' => $item->slug,
                    'title' => $item->title,
                    'image' => [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ]
                ];
            });

        $jpItems = Work::with('articles')
            ->when($types, function ($query, $types) {
                return $query->whereHas('specialties', function ($query) use ($types) {
                    $query->whereIn('name', $types);
                });
            })
            ->where('language_id', $jp->id)
            ->where('enabled', 1)
            ->take(10)
            ->get()
            ->map(function($item) {
                $image = $item->getFirstMedia();
                return [
                    'id' => $item->slug,
                    'title' => $item->title,
                    'image' => [
                        'url' => $image->getUrl(),
                        'width' => $image->getCustomProperty('width'),
                        'height' => $image->getCustomProperty('height'),
                    ]
                ];
            });

        return response()->json(
            [
                "result" => true,
                "type" => $specialties,
                "filter" => $filters,
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

        return response()->json([
            'result' => true,
            'en' => [
                'title' => 'MOCAP - en',
                'banner' => 'https://picsum.photos/id/10/1440/760',
                'youtubeLink' => 'https://www.youtube.com/watch?v=5bvo0crxQVY',
                'websiteLink' => 'https://www.youtube.com',
                'proportion' => [
                    [
                        'id' => '1',
                        'color' => '#9114f6',
                        'percentage' => 10
                    ],
                    [
                        'id' => '2',
                        'color' => '#560dfa',
                        'percentage' => 30
                    ],
                    [
                        'id' => '3',
                        'color' => '#55a7ff',
                        'percentage' => 40
                    ],
                    [
                        'id' => '4',
                        'color' => '#175eff',
                        'percentage' => 20
                    ],
                ],
                'previousPage' => '/ourworks/003',
                'nextPage' => '/ourworks/001',
                'section' => [
                    [
                        'id' => '1',
                        'type' => 'text',
                        'content' => '<p>iPhone 13 Pro was made for low light. The Wide camera adds a wider aperture and our largest sensor yet — and it leverages the LiDAR Scanner for Night mode portraits. Ultra Wide gets a wider aperture, a faster sensor, and all-new autofocus. And Telephoto now has Night mode.</p>
                                      <h2>Macro photography comes to iPhone.</h2>
                                      <p>With its redesigned lens and powerful autofocus system, the new Ultra Wide camera can focus at just 2 cm — making even the smallest details seem epic. Transform a leaf into abstract art. Capture a caterpillar’s fuzz. Magnify a dewdrop. The beauty of tiny awaits.</p>'
                    ],
                    [
                        'id' => '2',
                        'type' => 'photo',
                        'content' => [
                            [
                                'id' => '1',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'description' => 'say something...',
                                'width' => 540,
                                'height' => 360
                            ],
                            [
                                'id' => '2',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'description' => 'say something...',
                                'width' => 540,
                                'height' => 360
                            ],
                        ]
                    ],
                    [
                        'id' => '3',
                        'type' => 'album',
                        'content' => [
                            [
                                'id' => '1',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'description' => 'say something...',
                                'width' => 540,
                                'height' => 360
                            ],
                            [
                                'id' => '2',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'description' => 'say something...',
                                'width' => 540,
                                'height' => 360
                            ],
                        ]
                    ],
                    [
                        'id' => '4',
                        'type' => 'team',
                        'content' => [
                            [
                                'id' => '1',
                                'title' => 'Client',
                                'name' => [
                                    'TRUE YOGA FITNESS'
                                ],
                            ],
                            [
                                'id' => '2',
                                'title' => 'Creative Director',
                                'name' => [
                                    'Ian Ma 馬奕原'
                                ]
                            ],
                            [
                                'id' => '3',
                                'title' => 'Art Director',
                                'name' => [
                                    'Maggie Tsao 曹雅筑'
                                ]
                            ],
                            [
                                'id' => '4',
                                'title' => 'Web Developer',
                                'name' => [
                                    'Susan Huang 黃顥子'
                                ]
                            ],
                            [
                                'id' => '5',
                                'title' => 'Project Manager',
                                'name' => [
                                    'Scott Hsu 徐酋長'
                                ]
                            ],
                            [
                                'id' => '6',
                                'title' => 'Composition',
                                'name' => [
                                    'Chloe Shen 沈映彤',
                                    'Ming-Yuan Chuan 全明遠',
                                    'Weiting Chen 陳威廷',
                                    'Chia-Hua Yu 游佳華',
                                    'Hsiao Han Tseng 曾筱涵',
                                    'Shu-Min Wu 吳姝旻',
                                ]
                            ],
                            [
                                'id' => '7',
                                'title' => 'Website',
                                'name' => [
                                    'www.trueyogafitness.comdsdfsfdfdsffdfdfdf'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'cn' => [
                'title' => 'MOCAP - cn',
                'banner' => 'https://picsum.photos/id/10/1440/760',
                'youtubeLink' => 'https://www.youtube.com/watch?v=5bvo0crxQVY',
                'websiteLink' => 'https://www.youtube.com',
                'proportion' => [
                    [
                        'id' => '1',
                        'color' => '#9114f6',
                        'percentage' => 10
                    ],
                    [
                        'id' => '2',
                        'color' => '#560dfa',
                        'percentage' => 30
                    ],
                    [
                        'id' => '3',
                        'color' => '#55a7ff',
                        'percentage' => 40
                    ],
                    [
                        'id' => '4',
                        'color' => '#175eff',
                        'percentage' => 20
                    ],
                ],
                'previousPage' => '/ourworks/003',
                'nextPage' => '/ourworks/001',
                'section' => [
                    [
                        'id' => '1',
                        'type' => 'text',
                        'content' => '<p>iPhone 13 Pro was made for low light. The Wide camera adds a wider aperture and our largest sensor yet — and it leverages the LiDAR Scanner for Night mode portraits. Ultra Wide gets a wider aperture, a faster sensor, and all-new autofocus. And Telephoto now has Night mode.</p>
                                      <h2>Macro photography comes to iPhone.</h2>
                                      <p>With its redesigned lens and powerful autofocus system, the new Ultra Wide camera can focus at just 2 cm — making even the smallest details seem epic. Transform a leaf into abstract art. Capture a caterpillar’s fuzz. Magnify a dewdrop. The beauty of tiny awaits.</p>'
                    ],
                    [
                        'id' => '2',
                        'type' => 'photo',
                        'content' => [
                            [
                                'id' => '1',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'description' => 'say something...',
                                'width' => 540,
                                'height' => 360
                            ],
                            [
                                'id' => '2',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'description' => 'say something...',
                                'width' => 540,
                                'height' => 360
                            ],
                        ]
                    ],
                    [
                        'id' => '3',
                        'type' => 'album',
                        'content' => [
                            [
                                'id' => '1',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'width' => 540,
                                'height' => 360
                            ],
                            [
                                'id' => '2',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'width' => 540,
                                'height' => 360
                            ],
                        ]
                    ],
                    [
                        'id' => '4',
                        'type' => 'team',
                        'content' => [
                            [
                                'id' => '1',
                                'title' => 'Client',
                                'name' => [
                                    'TRUE YOGA FITNESS'
                                ],
                            ],
                            [
                                'id' => '2',
                                'title' => 'Creative Director',
                                'name' => [
                                    'Ian Ma 馬奕原'
                                ]
                            ],
                            [
                                'id' => '3',
                                'title' => 'Art Director',
                                'name' => [
                                    'Maggie Tsao 曹雅筑'
                                ]
                            ],
                            [
                                'id' => '4',
                                'title' => 'Web Developer',
                                'name' => [
                                    'Susan Huang 黃顥子'
                                ]
                            ],
                            [
                                'id' => '5',
                                'title' => 'Project Manager',
                                'name' => [
                                    'Scott Hsu 徐酋長'
                                ]
                            ],
                            [
                                'id' => '6',
                                'title' => 'Composition',
                                'name' => [
                                    'Chloe Shen 沈映彤',
                                    'Ming-Yuan Chuan 全明遠',
                                    'Weiting Chen 陳威廷',
                                    'Chia-Hua Yu 游佳華',
                                    'Hsiao Han Tseng 曾筱涵',
                                    'Shu-Min Wu 吳姝旻',
                                ]
                            ],
                            [
                                'id' => '7',
                                'title' => 'Website',
                                'name' => [
                                    'www.trueyogafitness.comdsdfsfdfdsffdfdfdf'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'jp' => [
                'title' => 'MOCAP - jp',
                'banner' => 'https://picsum.photos/id/10/1440/760',
                'youtubeLink' => 'https://www.youtube.com/watch?v=5bvo0crxQVY',
                'websiteLink' => 'https://www.youtube.com',
                'proportion' => [
                    [
                        'id' => '1',
                        'color' => '#9114f6',
                        'percentage' => 10
                    ],
                    [
                        'id' => '2',
                        'color' => '#560dfa',
                        'percentage' => 30
                    ],
                    [
                        'id' => '3',
                        'color' => '#55a7ff',
                        'percentage' => 40
                    ],
                    [
                        'id' => '4',
                        'color' => '#175eff',
                        'percentage' => 20
                    ],
                ],
                'previousPage' => '/ourworks/003',
                'nextPage' => '/ourworks/001',
                'section' => [
                    [
                        'id' => '1',
                        'type' => 'text',
                        'content' => '<p>iPhone 13 Pro was made for low light. The Wide camera adds a wider aperture and our largest sensor yet — and it leverages the LiDAR Scanner for Night mode portraits. Ultra Wide gets a wider aperture, a faster sensor, and all-new autofocus. And Telephoto now has Night mode.</p>
                                      <h2>Macro photography comes to iPhone.</h2>
                                      <p>With its redesigned lens and powerful autofocus system, the new Ultra Wide camera can focus at just 2 cm — making even the smallest details seem epic. Transform a leaf into abstract art. Capture a caterpillar’s fuzz. Magnify a dewdrop. The beauty of tiny awaits.</p>'
                    ],
                    [
                        'id' => '2',
                        'type' => 'photo',
                        'content' => [
                            [
                                'id' => '1',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'description' => 'say something...',
                                'width' => 540,
                                'height' => 360
                            ],
                            [
                                'id' => '2',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'description' => 'say something...',
                                'width' => 540,
                                'height' => 360
                            ],
                        ]
                    ],
                    [
                        'id' => '3',
                        'type' => 'album',
                        'content' => [
                            [
                                'id' => '1',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'width' => 540,
                                'height' => 360
                            ],
                            [
                                'id' => '2',
                                'url' => 'https://picsum.photos/id/1/540/360',
                                'width' => 540,
                                'height' => 360
                            ],
                        ]
                    ],
                    [
                        'id' => '4',
                        'type' => 'team',
                        'content' => [
                            [
                                'id' => '1',
                                'title' => 'Client',
                                'name' => [
                                    'TRUE YOGA FITNESS'
                                ],
                            ],
                            [
                                'id' => '2',
                                'title' => 'Creative Director',
                                'name' => [
                                    'Ian Ma 馬奕原'
                                ]
                            ],
                            [
                                'id' => '3',
                                'title' => 'Art Director',
                                'name' => [
                                    'Maggie Tsao 曹雅筑'
                                ]
                            ],
                            [
                                'id' => '4',
                                'title' => 'Web Developer',
                                'name' => [
                                    'Susan Huang 黃顥子'
                                ]
                            ],
                            [
                                'id' => '5',
                                'title' => 'Project Manager',
                                'name' => [
                                    'Scott Hsu 徐酋長'
                                ]
                            ],
                            [
                                'id' => '6',
                                'title' => 'Composition',
                                'name' => [
                                    'Chloe Shen 沈映彤',
                                    'Ming-Yuan Chuan 全明遠',
                                    'Weiting Chen 陳威廷',
                                    'Chia-Hua Yu 游佳華',
                                    'Hsiao Han Tseng 曾筱涵',
                                    'Shu-Min Wu 吳姝旻',
                                ]
                            ],
                            [
                                'id' => '7',
                                'title' => 'Website',
                                'name' => [
                                    'www.trueyogafitness.comdsdfsfdfdsffdfdfdf'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
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
