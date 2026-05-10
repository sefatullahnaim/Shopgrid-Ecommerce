<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Unit extends Model
{
    protected $fillable = ['name',  'code', 'description', 'status'];

    public static function newUnit($request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
        ]);
        
        return self::create([
            'name'        => $request->name,
            'code'        => $request->code,
            'description' => $request->description,
            'status'      => $request->status,
        ]);
    }

    // ✅ Update Unit
    public static function updateUnit($request, $id)
    {
        $Unit = self::findOrFail($id);

        $Unit->update([
            'name'        => $request->name,
            'code'        => $request->code,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return $Unit;
    }

    // ✅ Delete Unit
    public static function deleteUnit($id)
    {
        $Unit = self::findOrFail($id);

        if ($Unit->image && Storage::disk('public')->exists($Unit->image)) {
            Storage::disk('public')->delete($Unit->image);
        }

        return $Unit->delete();
    }

}
