<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SubCategory extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'image',
        'status'
    ];

    // ✅ Upload Image
    private static function uploadImage($request, $subCategory = null)
    {
        if ($request->hasFile('image')) {

            // upload new
            $newImage = $request->file('image')->store('subcategory-image', 'public');

            // delete old
            if ($subCategory && $subCategory->image && Storage::disk('public')->exists($subCategory->image)) {
                Storage::disk('public')->delete($subCategory->image);
            }

            return $newImage;
        }

        return $subCategory ? $subCategory->image : null;
    }

    // ✅ Create SubCategory
    public static function newSubCategory($request)
    {
        return self::create([
            'name'        => $request->name,
            'category_id' => $request->category_id, // IMPORTANT
            'description' => $request->description,
            'image'       => self::uploadImage($request),
            'status'      => $request->status,
        ]);
    }

    // ✅ Update SubCategory
    public static function updateSubCategory($request, $id)
    {
        $subCategory = self::findOrFail($id);

        $subCategory->update([
            'name'        => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image'       => self::uploadImage($request, $subCategory),
            'status'      => $request->status,
        ]);

        return $subCategory;
    }

    // ✅ Delete SubCategory
    public static function deleteSubCategory($id)
    {
        $subCategory = self::findOrFail($id);

        if ($subCategory->image && Storage::disk('public')->exists($subCategory->image)) {
            Storage::disk('public')->delete($subCategory->image);
        }

        return $subCategory->delete();
    }

    // ✅ Accessor (image url)
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('no-image.png');
    }

    // ✅ Relationship: SubCategory belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
