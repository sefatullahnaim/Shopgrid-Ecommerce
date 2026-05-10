<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'image', 'status'];
    // ✅ Upload Image (SAFE VERSION)
    private static function uploadImage($request, $category = null)
    {
        if ($request->hasFile('image')) {

            // Store new image first (IMPORTANT)
            $newImage = $request->file('image')->store('category-image', 'public');

            // Then delete old image
            if ($category && $category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            return $newImage;
        }

        return $category ? $category->image : null;
    }

    // ✅ Create
    public static function newCategory($request)
    {
        return self::create([
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => self::uploadImage($request),
            'status'      => $request->status,
        ]);
    }

    // ✅ Update
    public static function updateCategory($request, $id)
    {
        $category = self::findOrFail($id);

        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => self::uploadImage($request, $category),
            'status'      => $request->status,
        ]);

        return $category;
    }

    // ✅ Delete
    public static function deleteCategory($id)
    {
        $category = self::findOrFail($id);

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        return $category->delete();
    }

    // ✅ Accessor (NO MORE BROKEN IMAGES)
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('no-image.png');
    }

    // ✅ Relationship
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
