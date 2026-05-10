<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
    ];

    // ✅ Upload Image (SAFE VERSION)
    private static function uploadImage($request, $brand = null)
    {
        if ($request->hasFile('image')) {

            // Store new image first (IMPORTANT)
            $newImage = $request->file('image')->store('category-image', 'public');

            // Then delete old image
            if ($brand && $brand->image && Storage::disk('public')->exists($brand->image)) {
                Storage::disk('public')->delete($brand->image);
            }

            return $newImage;
        }

        return $brand ? $brand->image : null;
    }

    // ✅ Create
    public static function newBrand($request)
    {
        return self::create([
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => self::uploadImage($request),
            'status'      => $request->status,
        ]);
    }

    // ✅ Update
    public static function updateBrand($request, $id)
    {
        $brand = self::findOrFail($id);

        $brand->update([
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => self::uploadImage($request, $brand),
            'status'      => $request->status,
        ]);

        return $brand;
    }

    // ✅ Delete
    public static function deleteBrand($id)
    {
        $brand = self::findOrFail($id);

        if ($brand->image && Storage::disk('public')->exists($brand->image)) {
            Storage::disk('public')->delete($brand->image);
        }

        return $brand->delete();
    }

    // ✅ Accessor (NO MORE BROKEN IMAGES)
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('no-image.png');
    }
}
