<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\Unit;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index', ['products' => Product::get()]);
    }
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.detail', ['product' => $product]);
    }

    public function getproductbycategory($id)
    {
        $category = Category::findOrFail($id);

        $products = Product::where('category_id', $id)
            ->where('status', 1)
            ->latest()
            ->paginate(12);

        return view('website.category.index', compact('products', 'category'));
    }

    public function getproductbysubcategory($id)
    {
        $subcategory = SubCategory::findOrFail($id);

        $products = Product::where('sub_category_id', $id)
            ->where('status', 1)
            ->latest()
            ->paginate(12);

        return view('website.category.index', compact('products', 'subcategory'));
    }

    public function create()
    {
        return view('admin.product.create', [
            'categories' => Category::all(),
            'sub_categories' => SubCategory::all(),
            'brands' => Brand::all(),
            'units' => Unit::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'stock' => 'nullable|integer',
            'regular_price' => 'nullable|numeric',
            'selling_price' => 'nullable|numeric',
            'image' => 'nullable|image|max:5120', // Max 5MB
        ]);
        $productId = Product::newProduct($request);
        ProductImage::newProductImage($request->file('other_image'), $productId);
        return back()->with('message', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.edit', [
            'categories' => Category::all(),
            'sub_categories' => SubCategory::all(),
            'brands' => Brand::all(),
            'units' => Unit::all(),
            'product' => $product,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'unit_id' => 'required|exists:units,id',
            'name' => 'required|string|max:255',
            'stock' => 'nullable|integer',
            'regular_price' => 'nullable|numeric',
            'selling_price' => 'nullable|numeric',
            'image' => 'nullable|image|max:5120', // Max 5MB
        ]);

        Product::updateProduct($request, $id);

    if ($request->hasFile('other_image')) {
        ProductImage::updateProductOtherImage($request->file('other_image'), $id);
    }
        return redirect()->route('products.index')->with('message', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        Product::deleteProduct($id);
        return redirect()->route('products.index')->with('message', 'Product deleted successfully.');
    }
}
