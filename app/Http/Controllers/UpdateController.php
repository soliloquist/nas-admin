<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function index()
    {
        return view('updates.index');
    }

    public function create()
    {
        return view('updates.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Update $update)
    {
        //
    }

    public function edit($groupId, $languageId)
    {
        return view('updates.edit', compact('groupId', 'languageId'));
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
