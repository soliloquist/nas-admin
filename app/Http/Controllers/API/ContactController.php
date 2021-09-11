<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            "result" => true
        ]);
    }
}
