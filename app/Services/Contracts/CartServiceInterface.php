<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface CartServiceInterface
{
    public function getCart();

    public function add(int $productId, int $quantity, array $attributes = []);

    public function update(string $itemId, int $quantity);

    public function remove(string $itemId);

    public function clear();

    public function applyCoupon(string $couponCode);

    public function removeCoupon();
}
