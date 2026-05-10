@extends('website.master')

@section('title')
    Shopping Cart
@endsection

@section('body')

    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Cart</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="shopping-cart section">
        <div class="container">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @php
                $subtotal = 0;
            @endphp

            @if (!empty($cart['items']) && count($cart['items']) > 0)
                <div class="cart-list-head">

                    {{-- Cart Header --}}
                    <div class="cart-list-title">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-12"></div>

                            <div class="col-lg-3 col-md-3 col-12">
                                <p>Product Name</p>
                            </div>

                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Price</p>
                            </div>

                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Quantity</p>
                            </div>

                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Total</p>
                            </div>

                            <div class="col-lg-2 col-md-2 col-12">
                                <p>Action</p>
                            </div>
                        </div>
                    </div>

                    {{-- Cart Items --}}
                        @foreach ($cart['items'] as $item)
                        @php dd($item); @endphp
                        <div class="cart-single-list">
                            <div class="row align-items-center">

                                {{-- Product Image --}}
                                <div class="col-lg-1 col-md-1 col-12">

                                    @if (!empty($item['image']))
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                            class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('website/assets/images/no-image.png') }}" alt="No Image"
                                            class="img-fluid" style="width: 80px; height: 80px; object-fit: cover;">
                                    @endif

                                </div>

                                {{-- Product Info --}}
                                <div class="col-lg-3 col-md-3 col-12">

                                    <h5 class="product-name">
                                        <a href="#">
                                            {{ $item['name'] }}
                                        </a>
                                    </h5>

                                    @if (!empty($item['attributes']))
                                        <p class="product-des">

                                            @foreach ($item['attributes'] as $key => $value)
                                                <span class="d-block">
                                                    <em>{{ ucfirst($key) }}:</em>
                                                    {{ $value }}
                                                </span>
                                            @endforeach

                                        </p>
                                    @endif

                                </div>

                                {{-- Price --}}
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>
                                        ৳ {{ number_format($item['price'], 2) }}
                                    </p>
                                </div>

                                {{-- Quantity --}}
                                <div class="col-lg-2 col-md-2 col-12">

                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="d-flex align-items-center">

                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                min="1" class="form-control" style="width: 80px;">

                                            <button type="submit" class="btn btn-primary btn-sm ms-2">
                                                Update
                                            </button>

                                        </div>

                                    </form>

                                </div>

                                {{-- Total --}}
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>
                                        ৳ {{ number_format($item['total'], 2) }}
                                    </p>
                                </div>

                                {{-- Remove --}}
                                <div class="col-lg-2 col-md-2 col-12">

                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to remove this item?')">
                                            Remove
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

                {{-- Cart Summary --}}
                <div class="total-amount">
                    <div class="row">

                        {{-- Coupon --}}
                        <div class="col-lg-8 col-md-6 col-12">

                            <div class="left">
                                <div class="coupon">

                                    <form action="{{ route('cart.apply-coupon') }}" method="POST">
                                        @csrf

                                        <input type="text" name="coupon_code" placeholder="Enter Your Coupon">

                                        <div class="button">
                                            <button class="btn">
                                                Apply Coupon
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>

                        {{-- Summary --}}
                        <div class="col-lg-4 col-md-6 col-12">

                            @php
                                $tax = $cart['tax'] ?? 0;
                                $discount = $cart['discount'] ?? 0;
                                $total = $subtotal + $tax - $discount;
                            @endphp

                            <div class="right">

                                <ul>

                                    <li>
                                        Cart Subtotal
                                        <span>
                                            ৳ {{ number_format($subtotal, 2) }}
                                        </span>
                                    </li>

                                    @if ($tax > 0)
                                        <li>
                                            Tax
                                            <span>
                                                ৳ {{ number_format($tax, 2) }}
                                            </span>
                                        </li>
                                    @endif

                                    @if ($discount > 0)
                                        <li>
                                            Discount
                                            <span>
                                                -৳ {{ number_format($discount, 2) }}
                                            </span>
                                        </li>
                                    @endif

                                    <li class="last">
                                        You Pay
                                        <span>
                                            ৳ {{ number_format($total, 2) }}
                                        </span>
                                    </li>

                                </ul>

                                <div class="button">

                                    <a href="{{ route('product.checkout') }}" class="btn">
                                        Checkout
                                    </a>

                                    <a href="{{ route('products.index') }}" class="btn btn-alt">
                                        Continue Shopping
                                    </a>

                                </div>

                                {{-- Clear Cart --}}
                                <form action="{{ route('cart.clear') }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('Are you sure you want to clear the cart?')">
                                        Clear Cart
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>
                </div>
            @else
                {{-- Empty Cart --}}
                <div class="text-center py-5">

                    <h4>Your cart is empty</h4>

                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                        Continue Shopping
                    </a>

                </div>
            @endif

        </div>
    </div>

@endsection
