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
            'updateList' => [
                0 => [
                    'updateId' => 1,
                    'title' => 'title 1',
                    'date' => 'JUL 09',
                    'year' => '2020',
                    'image' => 'https://picsum.photos/700/175?random=1',
                ],
                1 => [
                    'updateId' => 2,
                    'title' => 'title 2',
                    'date' => 'JUL 09',
                    'year' => '2020',
                    'image' => 'https://picsum.photos/700/175?random=1',
                ],
            ],
        ]);
    }


    public function show(Request $request)
    {
        return response()->json([
            'result' => true,
            'title' => 'MOCAP',
            'image' => 'https://picsum.photos/1440/760',
            'date' => 'JUL 09',
            'year' => '2020',
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
