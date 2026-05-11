<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Hnooz\LaravelCart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        $cartItems = Cart::all();
        $cartCount = Cart::count();
        $cartTotal = Cart::total();
        return view('website.cart.index', compact(
            'cartItems',
            'cartCount',
            'cartTotal'
        ));
    }

    /**
     * Add product to cart
     */
    public function addTocart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $quantity = $request->quantity ?? 1;

        // Check stock
        if ($product->stock < $quantity) {
            return back()->with('error', 'Insufficient stock available');
        }

        Cart::add(
            (string) $product->id,
            $product->name,
            (float) $product->price,
            (int) $quantity,
            [
                'slug'        => $product->slug,
                'image'       => $product->image,
                'stock'       => $product->stock,
                'category_id' => $product->category_id ?? null,
            ]
        );

        // AJAX Response
        if ($request->ajax()) {
            return response()->json([
                'status'  => true,
                'message' => 'Product added to cart successfully',
                'count'   => Cart::count(),
                'total'   => Cart::total(),
            ]);
        }
        dd($request->all());
        return redirect()
            ->back()
            ->with('success', 'Product added to cart successfully');
    }

    /**
     * Increase quantity
     */
    public function increase(Request $request, $id)
    {
        $cartItems = Cart::all();

        if (!isset($cartItems[$id])) {

            if ($request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Cart item not found',
                ]);
            }

            return back()->with('error', 'Cart item not found');
        }

        $item = $cartItems[$id];

        // Stock validation
        if ($item['quantity'] >= $item['options']['stock']) {

            if ($request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Maximum stock reached',
                ]);
            }

            return back()->with('error', 'Maximum stock reached');
        }

        Cart::increase($id, 1);

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Quantity increased',
                'count' => Cart::count(),
                'total' => Cart::total(),
                'items' => Cart::all(),
            ]);
        }

        return back()->with('success', 'Quantity increased');
    }

    /**
     * Decrease quantity
     */
    public function decrease(Request $request, $id)
    {
        $cartItems = Cart::all();

        if (!isset($cartItems[$id])) {

            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart item not found',
                ]);
            }

            return back()->with('error', 'Cart item not found');
        }

        $item = $cartItems[$id];

        // Remove if quantity is 1
        if ($item['quantity'] <= 1) {

            Cart::remove($id);

            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Item removed from cart',
                    'count' => Cart::count(),
                    'total' => Cart::total(),
                ]);
            }

            return back()->with('success', 'Item removed from cart');
        }

        Cart::decrease($id, 1);

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Quantity decreased',
                'count' => Cart::count(),
                'total' => Cart::total(),
                'items' => Cart::all(),
            ]);
        }

        return back()->with('success', 'Quantity decreased');
    }

    /**
     * Remove cart item
     */
    public function remove(Request $request, $id)
    {
        Cart::remove($id);

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Item removed successfully',
                'count' => Cart::count(),
                'total' => Cart::total(),
            ]);
        }

        return back()->with('success', 'Item removed successfully');
    }

    /**
     * Clear cart
     */
    public function clear(Request $request)
    {
        Cart::clear();

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Cart cleared successfully',
            ]);
        }

        return back()->with('success', 'Cart cleared successfully');
    }
}
