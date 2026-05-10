<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.brand.index', [
            'brands' => Brand::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Brand::newBrand($request);
        return redirect()->route('brands.create')->with('message', 'Brand created successfully');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', ['brand' => $brand]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Brand::updateBrand($request, $id);

        return redirect()->route('brands.index')->with('message', 'Brand updated successfully.');
    }


    public function destroy($id)
    {
        Brand::deleteBrand($id);
        return redirect()->route('brands.index')->with('message', 'Brand deleted successfully');
    }
}
