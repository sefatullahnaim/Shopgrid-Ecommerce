@extends('website.master')

@section('body')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Cart</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="index.html">Shop</a></li>
                        <li>Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="shopping-cart section">
        <div class="container">
            <p class="text-center text-success">{{ session('message') }}</p>
            <div class="cart-list-head">
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12">
                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>Product Name</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Quantity</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Unit Price</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Subtotal</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>Remove</p>
                        </div>
                    </div>
                </div>
                @php($sum = 0)
                @foreach ($cartItems as $item)
                    <div class="cart-single-list">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a href="product-details.html"><img src="{{ asset('storage/' . $item->options['image']) }}"
                                        alt="#"></a>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <h5 class="product-name"><a href="product-details.html">
                                        {{ $item->name }}</a></h5>
                                <p class="product-des">
                                    <span><em>Type:</em> Mirrorless</span>
                                    <span><em>Color:</em> Black</span>
                                </p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <form action="{{ route('cart.update', $item->rowId) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="input-group">
                                        <input type="number" class="form-control" value="{{ $item->qty }}"
                                            name="qty" />
                                        <input type="submit" class="btn btn-success" value="Update" />
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ $item->price }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ $item->qty * $item->price }}</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <a class="remove-item" href="{{ route('cart.remove', $item->rowId) }}"><i
                                        class="lni lni-close"></i></a>
                            </div>
                        </div>
                    </div>
                    @php($sum = $sum + $item->qty * $item->price)
                @endforeach
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="#" target="_blank">
                                            <input name="Coupon" placeholder="Enter Your Coupon">
                                            <div class="button">
                                                <button class="btn">Apply Coupon</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        <li>
                                            Cart Subtotal
                                            <span id="subtotal">{{ $sum }} Tk</span>
                                        </li>

                                        <li>
                                            Tax Amount
                                            <span id="tax">{{ $tax = round($sum * 0.15) }} Tk</span>
                                        </li>
                                        <li>Shipping Cost<span>{{ $shippingCost = 100 }} TK</span></li>
                                        <li class="last">
                                            Total Pay
                                            <span id="totalPay">{{ $sum + $tax + $shippingCost }} Tk</span>
                                        </li>
                                    </ul>
                                    <div class="button">
                                        <a href="{{ route('product.checkout') }}" class="btn">Checkout</a>
                                        <a href="" class="btn btn-alt">Continue shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
