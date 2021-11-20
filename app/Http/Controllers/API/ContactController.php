<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'other' => 'required',
            'type' => 'required|exists:contacts,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "result" => false,
                'message' => $validator
            ]);
        }

        $content = Contact::find($request->type);

        Mail::to($content->email)->send(new ContactMail($request->name, $request->phome, $request->email, $request->other));

        return response()->json([
            "result" => true
        ]);
    }
}
