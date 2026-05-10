<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index',
        ['categories' => Category::all()]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        Category::newCategory($request);
        return back()->with('message', 'Category info create successfully.');
    }

    public function edit($id)
    {
        return view('admin.category.edit', ['category' => Category::find($id)]);
    }

    public function update(Request $request, $id)
    {
        Category::updateCategory($request,$id);
        return redirect('/categories')->with('message', 'Category info update successfully.');
    }

    public function destroy($id)
    {
        Category::deleteCategory($id);
        return redirect('/categories')->with('message','Category info delete successfully.');
    }

}
