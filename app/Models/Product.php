<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'brand_id',
        'unit_id',
        'name',
        'description',
        'price',
        'slug',
        'code',
        'stock',
        'regular_price',
        'selling_price',
        'short_description',
        'long_description',
        'image',
        'status',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'image',
        'featured_status',
        'status'
    ];

    private static function imageUpload($request, $product = null)
    {
        if ($request->hasFile('image')) {

            // Store new image first (IMPORTANT)
            $newImage = $request->file('image')->store('product-image', 'public');

            // Then delete old image
            if ($product && $product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            return $newImage;
        }

        return $product ? $product->image : null;
    }

    // ✅ Create Product
    public static function newProduct($request)
    {
        return self::create([
            'category_id'       => $request->category_id,
            'sub_category_id'   => $request->sub_category_id,
            'brand_id'          => $request->brand_id,
            'unit_id'           => $request->unit_id,
            'name'              => $request->name,
            'code'              => $request->code,
            'slug'              => $request->slug,
            'stock'             => $request->stock,
            'regular_price'     => $request->regular_price,
            'selling_price'     => $request->selling_price,
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'meta_title'        => $request->meta_title,
            'meta_keyword'      => $request->meta_keyword,
            'meta_description'  => $request->meta_description,
            'image'             => self::imageUpload($request),
            'featured_status'   => $request->featured_status,
            'status'            => $request->status,
        ]);
    }

    // ✅ Update Product
    public static function updateProduct($request, $id)
    {
        $product = self::findOrFail($id);
        $product->update([
            'category_id'       => $request->category_id,
            'sub_category_id'   => $request->sub_category_id,
            'brand_id'          => $request->brand_id,
            'unit_id'           => $request->unit_id,
            'name'              => $request->name,
            'code'              => $request->code,
            'slug'              => $request->slug,
            'stock'             => $request->stock,
            'regular_price'     => $request->regular_price,
            'selling_price'     => $request->selling_price,
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'meta_title'        => $request->meta_title,
            'meta_keyword'      => $request->meta_keyword,
            'meta_description'  => $request->meta_description,
            'image'             => self::imageUpload($request, $product),
            'featured_status'   => $request->featured_status,
            'status'            => $request->status,
        ]);

        return $product;
    }

    // ✅ Delete Product
    public static function deleteProduct($id)
    {
        $product = self::findOrFail($id);
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        return $product->delete();
    }

    // ✅ Accessor (Image URL)
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('no-image.png');
    }

    public function getDiscountPercentAttribute()
    {
        if (!$this->regular_price || !$this->selling_price) {
            return 0;
        }

        return round((($this->regular_price - $this->selling_price) / $this->regular_price) * 100);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
