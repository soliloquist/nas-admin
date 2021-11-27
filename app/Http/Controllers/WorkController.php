<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index()
    {
        return view('works.index');
    }

    public function create()
    {
        return view('works.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Work $work)
    {
        //
    }

    public function edit($groupId, $languageId)
    {
        return view('works.edit', compact('groupId', 'languageId'));
    }

    public function update(Request $request, Work $work)
    {
        //
    }

    public function destroy(Work $work)
    {
        //
    }
}
