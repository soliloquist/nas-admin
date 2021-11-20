<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class GetContactController extends Controller
{
    public function __invoke()
    {
        $list = Contact::where('enabled', 1)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => $item->type,
                'email' => $item->email
            ];
        });

        return [
            'result' => true,
            'list' => $list
        ];
    }
}
