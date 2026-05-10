<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\CartServiceInterface;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartServiceInterface $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        $cart = $this->cart->getCart();
        return view('website.cart.index', compact('cart'));
    }

    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $this->cart->add(
                $productId,
                $request->quantity,
                $request->input('attributes', [])
            );

            return back()->with('success', 'Product added to cart');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $this->cart->update($id, $request->quantity);
        return back()->with('success', 'Cart updated');
    }

    public function remove($id)
    {
        $this->cart->remove($id);
        return back()->with('success', 'Item removed');
    }

    public function clear()
    {
        $this->cart->clear();
        return back()->with('success', 'Cart cleared');
    }

    public function applyCoupon(Request $request)
    {
        $this->cart->applyCoupon($request->coupon_code);
        return back()->with('success', 'Coupon applied');
    }

    public function removeCoupon()
    {
        $this->cart->removeCoupon();
        return back()->with('success', 'Coupon removed');
    }
}
