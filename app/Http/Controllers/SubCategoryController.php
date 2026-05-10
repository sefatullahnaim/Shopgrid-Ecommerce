<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        return view('admin.sub-category.index', ['subCategories' => SubCategory::get()]);
    }

    public function create()
    {
        return view('admin.sub-category.create', ['categories' => Category::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        SubCategory::newSubCategory($request);

        return redirect()->route('sub-categories.create')->with('success', 'Sub-category created successfully.');
    }

    public function edit($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        return view('admin.sub-category.edit', ['subCategory' => $subCategory, 'categories' => Category::all()]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        SubCategory::updateSubCategory($request, $id);

        return redirect()->route('sub-categories.index')->with('updated', 'Sub-category updated successfully.');
    }

    public function destroy($id)
    {
        SubCategory::deleteSubCategory($id);
        return redirect()->route('sub-categories.index')->with('success', 'Sub-category deleted successfully.');
    }


}
