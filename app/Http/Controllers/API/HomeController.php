<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            "result" => true,
            "banner" => "https://picsum.photos/1920/709",
            "workList" => [
                [
                    "id" => 001,
                    "url" => "/",
                    "image" => "https://picsum.photos/360?random=1"
                ],
                [
                    "id" => 001,
                    "url" => "/",
                    "image" => "https://picsum.photos/360?random=2"
                ],
            ],
            "downloadUrl" => "/"
        ]);
    }
}
