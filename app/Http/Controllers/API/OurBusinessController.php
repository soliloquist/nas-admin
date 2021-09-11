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
            'businessList' => [
                0 => [
                    'id' => 1,
                    'type' => 'MOCAP',
                    'image' => 'https://picsum.photos/338/152?random=1',
                ],
                1 => [
                    'id' => 2,
                    'type' => 'NextLAB',
                    'image' => 'https://picsum.photos/338/152?random=2',
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
            'videoUrl' => 'https://www.youtube.com/watch?v=5bvo0crxQVY&ab_channel=NextAnimationStudio',
            'websiteUrl' => 'https://nentanimationstudio.com',
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
            ],
        ]);
    }
}
