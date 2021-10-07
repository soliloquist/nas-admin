<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            "result" => true,
            "bannerXS" => [
                "url" => "https://picsum.photos/id/1023/768/670",
                "width" => 768,
                "height" => 670,
            ],
            "bannerMD" => [
                "url" => "https://picsum.photos/id/1023/1920/700",
                "width" => 1920,
                "height" => 700,
            ],
            "downloadUrl" => "https://tw.apple.com/",
            "en" => [
                "list" => [
                    [
                        'id' => '1',
                        'title' => 'MOCAP',
                        'apiLink' => 'mocap',
                        'image' => [
                            'url' => 'https://picsum.photos/id/0/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '2',
                        'title' => 'NextLAB',
                        'apiLink' => '/ourbusiness/nextlab',
                        'image' => [
                            'url' => 'https://picsum.photos/id/10/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '3',
                        'title' => 'CLOUDEYE',
                        'apiLink' => '/ourbusiness/cloudeye',
                        'image' => [
                            'url' => 'https://picsum.photos/id/100/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '4',
                        'title' => 'TOMOLIVE',
                        'apiLink' => '/ourbusiness/tomolive',
                        'image' => [
                            'url' => 'https://picsum.photos/id/1000/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '5',
                        'title' => 'LIGHT STAGE',
                        'apiLink' => '/ourbusiness/light%20stage',
                        'image' => [
                            'url' => 'https://picsum.photos/id/1001/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '6',
                        'title' => 'NEWS DIRECT',
                        'apiLink' => '/ourbusiness/news%20direct',
                        'image' => [
                            'url' => 'https://picsum.photos/id/1002/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ]
                ]
            ],
            "cn" => [
                "list" => [
                    [
                        'id' => '1',
                        'title' => 'MOCAP',
                        'apiLink' => 'mocap',
                        'image' => [
                            'url' => 'https://picsum.photos/id/0/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '2',
                        'title' => 'NextLAB',
                        'apiLink' => '/ourbusiness/nextlab',
                        'image' => [
                            'url' => 'https://picsum.photos/id/10/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '3',
                        'title' => 'CLOUDEYE',
                        'apiLink' => '/ourbusiness/cloudeye',
                        'image' => [
                            'url' => 'https://picsum.photos/id/100/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '4',
                        'title' => 'TOMOLIVE',
                        'apiLink' => '/ourbusiness/tomolive',
                        'image' => [
                            'url' => 'https://picsum.photos/id/1000/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '5',
                        'title' => 'LIGHT STAGE',
                        'apiLink' => '/ourbusiness/light%20stage',
                        'image' => [
                            'url' => 'https://picsum.photos/id/1001/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '6',
                        'title' => 'NEWS DIRECT',
                        'apiLink' => '/ourbusiness/news%20direct',
                        'image' => [
                            'url' => 'https://picsum.photos/id/1002/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ]
                ]
            ],
            "jp" => [
                "list" => [
                    [
                        'id' => '1',
                        'title' => 'MOCAP',
                        'apiLink' => 'mocap',
                        'image' => [
                            'url' => 'https://picsum.photos/id/0/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '2',
                        'title' => 'NextLAB',
                        'apiLink' => '/ourbusiness/nextlab',
                        'image' => [
                            'url' => 'https://picsum.photos/id/10/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '3',
                        'title' => 'CLOUDEYE',
                        'apiLink' => '/ourbusiness/cloudeye',
                        'image' => [
                            'url' => 'https://picsum.photos/id/100/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '4',
                        'title' => 'TOMOLIVE',
                        'apiLink' => '/ourbusiness/tomolive',
                        'image' => [
                            'url' => 'https://picsum.photos/id/1000/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '5',
                        'title' => 'LIGHT STAGE',
                        'apiLink' => '/ourbusiness/light%20stage',
                        'image' => [
                            'url' => 'https://picsum.photos/id/1001/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ],
                    [
                        'id' => '6',
                        'title' => 'NEWS DIRECT',
                        'apiLink' => '/ourbusiness/news%20direct',
                        'image' => [
                            'url' => 'https://picsum.photos/id/1002/300/300',
                            'width' => 300,
                            'height' => 300,
                        ]
                    ]
                ]
            ],
        ]);
    }
}
