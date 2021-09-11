<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class GetOurVisionController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'result' => true,
            'banner' => [
                'url' => 'https://nentanimationstudio.com',
                'image' => 'https://picsum.photos/1264/711',
            ],
            'clientList' => [
                0 => [
                    'id' => 1,
                    'image' => 'https://picsum.photos/120/120',
                ],
                1 => [
                    'id' => 2,
                    'image' => 'https://picsum.photos/2400/120',
                ],
            ],
            'teamList' => [
                0 => [
                    'id' => 1,
                    'department' => 'develop',
                    'memberList' => [
                        0 => [
                            'id' => 1,
                            'name' => 'bo cheng chen',
                            'title' => 'CEO',
                            'image' => 'https://picsum.photos/341/334?random=1',
                            'type' => [
                                'name' => 'Art',
                                'color' => '#fff000',
                            ],
                        ],
                        1 => [
                            'id' => 2,
                            'name' => 'bo cheng chen',
                            'title' => 'CEO',
                            'image' => 'https://picsum.photos/341/334?random=2',
                            'type' => [
                                'name' => 'Art',
                                'color' => '#fff000',
                            ],
                        ],
                    ],
                ],
                1 => [
                    'id' => 2,
                    'department' => 'creative',
                    'memberList' => [
                        0 => [
                            'id' => 1,
                            'name' => 'bo cheng chen',
                            'title' => 'CEO',
                            'image' => 'https://picsum.photos/341/334?random=3',
                            'type' => [
                                'name' => 'Art',
                                'color' => '#fff000',
                            ],
                        ],
                        1 => [
                            'id' => 2,
                            'name' => 'bo cheng chen',
                            'title' => 'CEO',
                            'image' => 'https://picsum.photos/341/334?random=4',
                            'type' => [
                                'name' => 'Art',
                                'color' => '#fff000',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
