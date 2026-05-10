<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image'];

    // ✅ Create Images
    public static function newProductImage($images, $productId)
    {
        if (!$images) return;

        foreach ($images as $image) {
            $path = $image->store('product-other-images', 'public');

            self::create([
                'product_id' => $productId,
                'image'      => $path,
            ]);
        }
    }

    // ✅ Update Images
    public static function updateProductOtherImage($images, $productId)
    {
        self::deleteProductOtherImage($productId);
        self::newProductImage($images, $productId);
    }

    // ✅ Delete Images
    public static function deleteProductOtherImage($productId)
    {
        $images = self::where('product_id', $productId)->get();

        foreach ($images as $img) {
            if ($img->image && Storage::disk('public')->exists($img->image)) {
                Storage::disk('public')->delete($img->image);
            }

            $img->delete();
        }
    }

    // ✅ Accessor (Image URL)
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('no-image.png');
    }

    // ✅ Relationship
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
