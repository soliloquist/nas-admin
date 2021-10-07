<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class GetOurVisionController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'result' => true,
            'en' => [
                'intro' => '<p>The only constant in this world is constant change. Just like the essence of animation, every beautiful minute and second accumulates wonderful frame by </p>
                            <p>In the future, we will not only watch animated images in front of TV or in movie theaters, but also experience the touch of animation brought to us through handheld devices, VR devices, or in interactive exhibitions.</p>
                            <p>Animation not only shows the bright future imagined, but also inspires us to create a future beyond imagination.</p>
                            <p> We change the view you see You’ll change the view of world.</p>
                            <p>We have the most complete image creative team in the industry. From creativity to production, production to logistics, complete and diversified integrated services next animation use animation to predict the future.</p>'
            ],
            'cn' => [
                'intro' => '<p>The only constant in this world is constant change. Just like the essence of animation, every beautiful minute and second accumulates wonderful frame by </p>
                            <p>In the future, we will not only watch animated images in front of TV or in movie theaters, but also experience the touch of animation brought to us through handheld devices, VR devices, or in interactive exhibitions.</p>
                            <p>Animation not only shows the bright future imagined, but also inspires us to create a future beyond imagination.</p>
                            <p> We change the view you see You’ll change the view of world.</p>
                            <p>We have the most complete image creative team in the industry. From creativity to production, production to logistics, complete and diversified integrated services next animation use animation to predict the future.</p>'
            ],
            'jp' => [
                'intro' => '<p>The only constant in this world is constant change. Just like the essence of animation, every beautiful minute and second accumulates wonderful frame by </p>
                            <p>In the future, we will not only watch animated images in front of TV or in movie theaters, but also experience the touch of animation brought to us through handheld devices, VR devices, or in interactive exhibitions.</p>
                            <p>Animation not only shows the bright future imagined, but also inspires us to create a future beyond imagination.</p>
                            <p> We change the view you see You’ll change the view of world.</p>
                            <p>We have the most complete image creative team in the industry. From creativity to production, production to logistics, complete and diversified integrated services next animation use animation to predict the future.</p>'
            ],
            'video' => 'https://www.youtube.com/embed/ZbwBVWnonzA',
            'team' => [
                [
                    'id' => '1',
                    'department' => 'DEVELOP',
                    'member' => [
                        [
                            'id' => '1',
                            'name' => 'bochinG young',
                            'title' => 'ceo',
                            'type' => '#fff000',
                            'image' => [
                                'url' => 'https://picsum.photos/id/31/300/300',
                                'width' => 300,
                                'height' => 300
                            ]
                        ],
                        [
                            'id' => '2',
                            'name' => 'bochinG young',
                            'title' => 'ceo',
                            'type' => '#fff000',
                            'image' => [
                                'url' => 'https://picsum.photos/id/31/300/300',
                                'width' => 300,
                                'height' => 300
                            ]
                        ],
                        [
                            'id' => '3',
                            'name' => 'bochinG young',
                            'title' => 'ceo',
                            'type' => '#fff000',
                            'image' => [
                                'url' => 'https://picsum.photos/id/31/300/300',
                                'width' => 300,
                                'height' => 300
                            ]
                        ],
                    ],
                ],
                [
                    'id' => '2',
                    'department' => 'CREATIVE',
                    'member' => [
                        [
                            'id' => '1',
                            'name' => 'bochinG young',
                            'title' => 'ceo',
                            'type' => '#fff000',
                            'image' => [
                                'url' => 'https://picsum.photos/id/31/300/300',
                                'width' => 300,
                                'height' => 300
                            ]
                        ],
                        [
                            'id' => '2',
                            'name' => 'bochinG young',
                            'title' => 'ceo',
                            'type' => '#fff000',
                            'image' => [
                                'url' => 'https://picsum.photos/id/31/300/300',
                                'width' => 300,
                                'height' => 300
                            ]
                        ],
                    ],
                ],
            ],
            'client' => [
                [
                    'id' => '1',
                    'image' => [
                        'url' => 'https://picsum.photos/id/101/100/30',
                        'width' => 100,
                        'height' => 30
                    ],
                ],
                [
                    'id' => '2',
                    'image' => [
                        'url' => 'https://picsum.photos/id/101/100/30',
                        'width' => 100,
                        'height' => 30
                    ],
                ],
            ],
        ]);
    }
}
