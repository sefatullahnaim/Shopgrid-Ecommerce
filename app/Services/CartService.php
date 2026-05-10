<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Coupon;
use App\Services\Contracts\CartServiceInterface;
use Saeedvir\ShoppingCart\Facades\Cart;

class CartService implements CartServiceInterface
{
    public function getCart()
    {
        return Cart::toArray();
    }

    public function add(int $productId, int $quantity, array $attributes = [])
{
    $product = Product::findOrFail($productId);

    if ($product->stock < $quantity) {
        throw new \Exception('Insufficient stock available');
    }

    Cart::add(
        $product->id,
        (int) $quantity,
        $product->selling_price,
        $attributes   // ✅ MUST BE ARRAY
    );
}

    public function update(string $itemId, int $quantity)
    {
        $item = Cart::get($itemId);

        if (!$item) {
            throw new \Exception('Item not found in cart');
        }

        Cart::update($itemId, [
            'quantity' => $quantity
        ]);
    }

    public function remove(string $itemId)
    {
        Cart::remove($itemId);
    }

    public function clear()
    {
        Cart::clear();
    }

    public function applyCoupon(string $couponCode)
    {
        Cart::applyCoupon($couponCode, function ($code, $cart) {

            $coupon = Coupon::where('code', $code)
                ->where('is_active', true)
                ->where('starts_at', '<=', now())
                ->where('expires_at', '>=', now())
                ->first();

            if (!$coupon) {
                return false;
            }

            if ($cart->subtotal() < $coupon->minimum_purchase) {
                return false;
            }

            if ($coupon->type === 'percentage') {
                $cart->condition('coupon', 'discount', $coupon->value, 'percentage');
            } else {
                $cart->condition('coupon', 'discount', $coupon->value, 'fixed');
            }

            return true;
        });
    }

    public function removeCoupon()
    {
        Cart::removeCondition('coupon');
    }
}
