<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        return view('admin.unit.index', ['units' => Unit::latest()->get()]);
    }

    public function create()
    {
        return view('admin.unit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
        ]);

        Unit::newUnit($request);
        return redirect()->route('units.create')->with('message', 'Unit created successfully.');
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('admin.unit.edit',['unit' => $unit]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        Unit::updateUnit($request, $id);
        return redirect()->route('units.index')->with('message','Unit updated successfully.');
    }

    public function destroy($id)
    {
        Unit::deleteUnit($id);
        return redirect()->route('units.index')->with('message','Unit deleted successfully');
    }
}
