<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public function index()
    {
        //return Cart::content();
        return view('website.cart.index', ['cartItems' => Cart::content()]);
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);
        Cart::add([
            'id'        => $product->id,
            'name'      => $product->name,
            'qty'       => $request->qty,
            'price'     => $product->selling_price,
            'weight'    => 0,
            'options'   => [
                'image'     => $product->image,
                'category'  => $product->category->name,
                'brand'     => $product->brand->name,
            ]
        ]);
        // return redirect('/cart-products'); // url
        return redirect()->route('cart.index'); // name
    }

    public function updateCart(Request $request, $rowId)
    {
        Cart::update($rowId, $request->qty);
        return redirect()->route('cart.index')->with('message', 'Cart product info updated successfully.');
    }

    public function removeCart($rowId)
    {
        Cart::remove($rowId);
        return redirect()->route('cart.index')->with('message', 'Cart product info removed successfully.');
    }
}
