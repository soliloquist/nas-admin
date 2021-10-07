<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function index()
    {
        return response()->json([
            'result' => true,
            'totalPage' => 2,
            'year' => [
                [
                    'id' => '1',
                    'text' => '2021',
                ],
                [
                    'id' => '2',
                    'text' => '2020',
                ],
            ],
            'en' => [
                'list' => [
                    [
                        'id' => '1',
                        'date' => [
                            'year' => '2021',
                            'month' => 'AUG',
                            'day' => '09',
                        ],
                        'title' => 'news title 1',
                        'image' => 'https://picsum.photos/id/1/660/300',
                    ],
                    [
                        'id' => '2',
                        'date' => [
                            'year' => '2021',
                            'month' => 'AUG',
                            'day' => '09',
                        ],
                        'title' => 'news title 2',
                        'image' => 'https://picsum.photos/id/2/660/300',
                    ],
                    [
                        'id' => '3',
                        'date' => [
                            'year' => '2021',
                            'month' => 'AUG',
                            'day' => '09',
                        ],
                        'title' => 'news title 3',
                        'image' => 'https://picsum.photos/id/3/660/300',
                    ],
                ]
            ],
            'cn' => [
                'list' => [
                    [
                        'id' => '1',
                        'date' => [
                            'year' => '2021',
                            'month' => 'AUG',
                            'day' => '09',
                        ],
                        'title' => 'news title 1',
                        'image' => 'https://picsum.photos/id/1/660/300',
                    ],
                    [
                        'id' => '2',
                        'date' => [
                            'year' => '2021',
                            'month' => 'AUG',
                            'day' => '09',
                        ],
                        'title' => 'news title 2',
                        'image' => 'https://picsum.photos/id/2/660/300',
                    ],
                    [
                        'id' => '3',
                        'date' => [
                            'year' => '2021',
                            'month' => 'AUG',
                            'day' => '09',
                        ],
                        'title' => 'news title 3',
                        'image' => 'https://picsum.photos/id/3/660/300',
                    ],
                ]
            ],
            'jp' => [
                'list' => [
                    [
                        'id' => '1',
                        'date' => [
                            'year' => '2021',
                            'month' => 'AUG',
                            'day' => '09',
                        ],
                        'title' => 'news title 1',
                        'image' => 'https://picsum.photos/id/1/660/300',
                    ],
                    [
                        'id' => '2',
                        'date' => [
                            'year' => '2021',
                            'month' => 'AUG',
                            'day' => '09',
                        ],
                        'title' => 'news title 2',
                        'image' => 'https://picsum.photos/id/2/660/300',
                    ],
                    [
                        'id' => '3',
                        'date' => [
                            'year' => '2021',
                            'month' => 'AUG',
                            'day' => '09',
                        ],
                        'title' => 'news title 3',
                        'image' => 'https://picsum.photos/id/3/660/300',
                    ],
                ]
            ],
        ]);
    }


    public function show(Request $request)
    {
        return response()->json([
            'result' => true,
            'en' => [
                'title' => 'News Title - en',
                'banner' => 'https://picsum.photos/id/1/1440/760',
                'youtubeLink' => 'https://www.youtube.com/watch?v=5bvo0crxQVY',
                'websiteLink' => 'https://www.youtube.com',
                'previousPage' => '/ourupdates/003',
                'nextPage' => '/ourupdates/001',
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
                ]
            ],
            'cn' => [
                'title' => 'News Title - en',
                'banner' => 'https://picsum.photos/id/1/1440/760',
                'youtubeLink' => 'https://www.youtube.com/watch?v=5bvo0crxQVY',
                'websiteLink' => 'https://www.youtube.com',
                'previousPage' => '/ourupdates/003',
                'nextPage' => '/ourupdates/001',
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
                ]
            ],
            'jp' => [
                'title' => 'News Title - en',
                'banner' => 'https://picsum.photos/id/1/1440/760',
                'youtubeLink' => 'https://www.youtube.com/watch?v=5bvo0crxQVY',
                'websiteLink' => 'https://www.youtube.com',
                'previousPage' => '/ourupdates/003',
                'nextPage' => '/ourupdates/001',
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
                ]
            ],
        ]);
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
