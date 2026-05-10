<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function decreaseStock($productId, $qty)
    {
        $product = Product::findOrFail($productId);
        $product->decrement('stock', $qty);
    }
}
