<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopGridController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category:id,name')
            ->where('status', 1)              // ✅ published
            ->where('featured_status', 1)     // ✅ featured
            ->latest()
            ->take(8)
            ->get(['id', 'name', 'category_id', 'image', 'selling_price', 'regular_price']);

        return view('website.home.index', compact('featuredProducts'));
    }

    public function categories($id)
    {
        $categories = Category::findOrFail($id);

        $products = Product::with('category:id,name')
            ->where('category_id', $id)
            ->where('status', 1)
            ->latest()
            ->paginate(12);

        return view('website.category.index', compact('products', 'categories'));

    }
    public function subCategory($id)
    {
        $subcategories = SubCategory::findOrFail($id);

        $products = Product::with('category:id,name')
            ->where('sub_category_id', $id)
            ->where('status', 1)
            ->latest()
            ->paginate(12);

        return view('website.category.index', compact('products', 'subcategories'));

    }

    public function details($id)
    {
        return view('website.product.product', ['product' => Product::findOrFail($id)]);
    }

}
