<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;

class OurWorkController extends Controller
{
    public function index()
    {
        return response()->json(
            [
                "result" => true,
                "type" => [
                    [
                        "id" => '1',
                        'color' => '#9114f6',
                        'text' => 'Art',
                    ],
                    [
                        "id" => '2',
                        'color' => '#560dfa',
                        'text' => 'Art',
                    ],
                    [
                        "id" => '3',
                        'color' => '#55a7ff',
                        'text' => 'Model',
                    ],
                ],
                "filter" => [
                    [
                        "id" => '1',
                        "name" => "all"
                    ],
                    [
                        "id" => '2',
                        "name" => "Animation"
                    ]
                ],
                'en' => [
                    'works' => [
                        [
                            'id' => '1',
                            'title' => 'Project-1',
                            'image' => [
                                'url' => 'https://picsum.photos/id/10/600/600',
                                'width' => 600,
                                'height' => 600
                            ]
                        ],
                        [
                            'id' => '2',
                            'title' => 'Project-2',
                            'image' => [
                                'url' => 'https://picsum.photos/id/11/600/500',
                                'width' => 600,
                                'height' => 500
                            ]
                        ],
                        [
                            'id' => '3',
                            'title' => 'Project-3',
                            'image' => [
                                'url' => 'https://picsum.photos/id/12/600/300',
                                'width' => 600,
                                'height' => 300
                            ]
                        ],
                        [
                            'id' => '4',
                            'title' => 'Project-4',
                            'image' => [
                                'url' => 'https://picsum.photos/id/13/600/500',
                                'width' => 600,
                                'height' => 500
                            ]
                        ],
                    ]
                ],
                'cn' => [
                    'works' => [
                        [
                            'id' => '1',
                            'title' => 'Project-1',
                            'image' => [
                                'url' => 'https://picsum.photos/id/10/600/600',
                                'width' => 600,
                                'height' => 600
                            ]
                        ],
                        [
                            'id' => '2',
                            'title' => 'Project-2',
                            'image' => [
                                'url' => 'https://picsum.photos/id/11/600/500',
                                'width' => 600,
                                'height' => 500
                            ]
                        ],
                        [
                            'id' => '3',
                            'title' => 'Project-3',
                            'image' => [
                                'url' => 'https://picsum.photos/id/12/600/300',
                                'width' => 600,
                                'height' => 300
                            ]
                        ],
                        [
                            'id' => '4',
                            'title' => 'Project-4',
                            'image' => [
                                'url' => 'https://picsum.photos/id/13/600/500',
                                'width' => 600,
                                'height' => 500
                            ]
                        ],
                    ]
                ],
                'jp' => [
                    'works' => [
                        [
                            'id' => '1',
                            'title' => 'Project-1',
                            'image' => [
                                'url' => 'https://picsum.photos/id/10/600/600',
                                'width' => 600,
                                'height' => 600
                            ]
                        ],
                        [
                            'id' => '2',
                            'title' => 'Project-2',
                            'image' => [
                                'url' => 'https://picsum.photos/id/11/600/500',
                                'width' => 600,
                                'height' => 500
                            ]
                        ],
                        [
                            'id' => '3',
                            'title' => 'Project-3',
                            'image' => [
                                'url' => 'https://picsum.photos/id/12/600/300',
                                'width' => 600,
                                'height' => 300
                            ]
                        ],
                        [
                            'id' => '4',
                            'title' => 'Project-4',
                            'image' => [
                                'url' => 'https://picsum.photos/id/13/600/500',
                                'width' => 600,
                                'height' => 500
                            ]
                        ],
                    ]
                ],
            ]
        );
    }


    public function show(Request $request)
    {
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
}
