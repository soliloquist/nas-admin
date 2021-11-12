<?php

namespace App\Http\Controllers;

use App\Models\ContactType;
use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
    public function index()
    {
        return view('contact-types.index');
    }

    public function create()
    {
        return view('contact-types.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ContactType $contactType)
    {
        //
    }

    public function edit(ContactType $contactType)
    {
        return view('contact-types.edit', compact('contactType'));
    }

    public function update(Request $request, ContactType $contactType)
    {
        //
    }

    public function destroy(ContactType $contactType)
    {
        //
    }
}
