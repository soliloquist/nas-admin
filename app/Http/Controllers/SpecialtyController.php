<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        return view('specialties.index');
    }

    public function create()
    {
        return view('specialties.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Specialty $specialty)
    {
        //
    }

    public function edit(Specialty $specialty)
    {
        return view('specialties.edit', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty)
    {
        //
    }

    public function destroy(Specialty $specialty)
    {
        //
    }
}
