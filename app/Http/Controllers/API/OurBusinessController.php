<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class OurBusinessController extends Controller
{
    public function index()
    {
        return response()->json([
            'result' => true,
            'list' => [
                [
                    'id' => '1',
                    'type' => 'MOCAP',
                    'apiLink' => '/ourbusiness/mocap',
                    'image' => 'https://picsum.photos/338/152?random=1',
                ],
                [
                    'id' => '2',
                    'type' => 'LIGHT STAGE',
                    'apiLink' => '/ourbusiness/light%20stage',
                    'image' => 'https://picsum.photos/338/152?random=2',
                ],
            ],
        ]);
    }


    public function show(Request $request)
    {
        return response()->json([
            'result' => true,
            'en' => [
                'title' => 'MOCAP - en',
                'banner' => 'https://picsum.photos/id/1/1440/760',
                'youtubeLink' => 'https://www.youtube.com/watch?v=5bvo0crxQVY',
                'websiteLink' => 'https://www.youtube.com',
                'previousPage' => '/ourbusiness/003',
                'nextPage' => '/ourbusiness/001',
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
                'title' => 'MOCAP - cn',
                'banner' => 'https://picsum.photos/id/1/1440/760',
                'youtubeLink' => 'https://www.youtube.com/watch?v=5bvo0crxQVY',
                'websiteLink' => 'https://www.youtube.com',
                'previousPage' => '/ourbusiness/003',
                'nextPage' => '/ourbusiness/001',
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
                'title' => 'MOCAP - jp',
                'banner' => 'https://picsum.photos/id/1/1440/760',
                'youtubeLink' => 'https://www.youtube.com/watch?v=5bvo0crxQVY',
                'websiteLink' => 'https://www.youtube.com',
                'previousPage' => '/ourbusiness/003',
                'nextPage' => '/ourbusiness/001',
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
                ]
            ],
        ]);
    }
}
