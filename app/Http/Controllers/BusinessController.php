<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        return view('businesses.index');
    }

    public function create()
    {
        return view('businesses.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Business $business)
    {
        //
    }

    public function edit($groupId)
    {
        return view('businesses.edit', compact('groupId'));
    }

    public function update(Request $request, Business $business)
    {
        //
    }

    public function destroy(Business $business)
    {
        //
    }
}
