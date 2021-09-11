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
                "typeList" => [
                    [
                        "id" => 1,
                        "name" => "Art"
                    ],
                    [
                        "id" => 2,
                        "name" => "Animation"
                    ]
                ],
                "filterList" => [
                    [
                        "id" => 1,
                        "name" => "all"
                    ],
                    [
                        "id" => 2,
                        "name" => "Animation"
                    ]
                ],
                "workList" => [
                    [
                        "workId" => 1,
                        "image" => "https://picsum.photos/800/800?random=1",
                        "proportion" => [
                            [
                                "name" => "Art",
                                "color" => "#fff000",
                                "percentage" => 10
                            ],
                            [
                                "name" => "Animation",
                                "color" => "#fff000",
                                "percentage" => 80
                            ],
                            [
                                "name" => "Model",
                                "color" => "#fff000",
                                "percentage" => 10
                            ]
                        ]
                    ],
                    [
                        "workId" => 2,
                        "image" => "https://picsum.photos/800/800?random=2",
                        "proportion" => [
                            [
                                "name" => "Art",
                                "color" => "#fff000",
                                "percentage" => 10
                            ],
                            [
                                "name" => "Animation",
                                "color" => "#fff000",
                                "percentage" => 80
                            ],
                            [
                                "name" => "Model",
                                "color" => "#fff000",
                                "percentage" => 10
                            ]
                        ]
                    ]
                ]
            ]
        );
    }


    public function show(Request $request)
    {
        return response()->json([
            'result' => true,
            'title' => 'MOCAP',
            'image' => 'https://picsum.photos/1440/760',
            'videoUrl' => 'https://www.youtube.com/watch?v=5bvo0crxQVY&ab_channel=NextAnimationStudio',
            'websiteUrl' => 'https://nentanimationstudio.com',
            'proportion' => [
                0 => [
                    'type' => 'Art',
                    'percentage' => 10,
                ],
                1 => [
                    'type' => 'Animation',
                    'percentage' => 80,
                ],
                2 => [
                    'type' => 'Model',
                    'percentage' => 10,
                ],
            ],
            'contentList' => [
                0 => [
                    'id' => 1,
                    'type' => 'p',
                    'content' => '<h1>say something...</h1>',
                ],
                1 => [
                    'id' => 2,
                    'type' => 'title',
                    'content' => 'CHALLANGE',
                ],
                2 => [
                    'id' => 3,
                    'type' => 'image',
                    'content' => 'https://picsum.photos/1074/395',
                ],
                3 => [
                    'id' => 4,
                    'type' => 'album',
                    'content' => [
                        0 => [
                            'id' => 1,
                            'image' => 'https://picsum.photos/537/395?random=1',
                        ],
                        1 => [
                            'id' => 2,
                            'image' => 'https://picsum.photos/537/395?random=2',
                        ],
                    ],
                ],
            ],
            'team' => [
                0 => [
                    'id' => 1,
                    'title' => 'Creative Director',
                    'member' => [
                        0 => 'Ian Ma 馬奕原',
                    ],
                ],
                1 => [
                    'id' => 2,
                    'title' => 'Creative Director',
                    'member' => [
                        0 => 'Ian Ma 馬奕原',
                        1 => 'Ian Ma 馬奕原',
                    ],
                ],
            ],
        ]);
    }
}
