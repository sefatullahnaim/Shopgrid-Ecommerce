@extends('website.master')

@section('body')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">checkout</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="index.html">Shop</a></li>
                        <li>checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('checkout.new.order') }}" method="post">
        @csrf
        <section class="checkout-wrapper section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="checkout-steps-form-style-1">
                            <ul id="accordionExample">
                                <li>
                                    <h6 class="title"> Please Give Your Order Checkout Inbformation </h6>
                                    <section class="checkout-steps-form-content collapse show">
                                        <div class="row">
                                            @if (!Session::get('customer_id'))
                                                <div class="col-md-12">
                                                    <div class="single-form form-default">
                                                        <label>Full Name</label>
                                                        <div class="row">
                                                            <div class="col-md-12 form-input form">
                                                                <input type="text" placeholder="Full Name"
                                                                    name="name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-form form-default">
                                                        <label>Email Address</label>
                                                        <div class="form-input form">
                                                            <input type="email" name="email"
                                                                placeholder="Email Address" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="single-form form-default">
                                                        <label>Phone Number</label>
                                                        <div class="form-input form">
                                                            <input type="number" placeholder="Phone Number"
                                                                name="mobile" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>Delivery Address</label>
                                                    <div class="form-input form">
                                                        <textarea name="delivery_address" class="form-control pt-2" placeholder="Delivery Address"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="mt-3">Payment Method</label>
                                                <div class="single-checkbox checkbox-style-3">
                                                    <label class="me-3"> <input type="radio" name="payment_method"
                                                            value="cash" checked /> Cash On Delivery </label>
                                                    <label> <input type="radio" name="payment_method" value="online" />
                                                        Online </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form button">
                                                    <button class="btn" type="submit">Confirm Order</button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="checkout-sidebar">
                            <div class="checkout-sidebar-price-table">
                                <h5 class="title">Your Order Summery</h5>
                                <div class="sub-total-price">
                                    @php($sum = 0)
                                    @foreach (Cart::content() as $cartProduct)
                                        <div class="total-price">
                                            <p class="value pe-3">{{ $cartProduct->name }} - ( {{ $cartProduct->price }} *
                                                {{ $cartProduct->qty }} ) : </p>
                                            <p class="price"> {{ $cartProduct->price * $cartProduct->qty }} </p>
                                        </div>
                                        @php($sum = $sum + $cartProduct->price * $cartProduct->qty)
                                    @endforeach
                                </div>
                                <div class="total-payable">
                                    <div class="payable-price">
                                        <p class="value">Subotal Price:</p>
                                        <p class="price">{{ $sum }}</p>
                                    </div>
                                    <div class="payable-price">
                                        <p class="value">Tax Amount:</p>
                                        <p class="price">{{ $tax = round($sum * 0.15) }}</p>
                                    </div>
                                    <div class="payable-price">
                                        <p class="value">Shipping Amount:</p>
                                        <p class="price">{{ $shipping = 100 }}</p>
                                    </div>
                                    <div class="payable-price">
                                        <p class="value">Total Payable:</p>
                                        <p class="price">{{ $totalPayable = $sum + $tax + $shipping }}</p>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="order_total" value="{{ $totalPayable }}" />
                            <input type="hidden" name="tax_total" value="{{ $tax }}" />
                            <input type="hidden" name="shipping_total" value="{{ $shipping }}" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
