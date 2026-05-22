@extends('website.master')
@section('body')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Customer</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="#"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="#">Customer</a></li>
                        <li>Order</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="checkout-wrapper section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    @include('customer.includes.menu')
                </div>
                <div class="col-md-8">
                    <div class="card card-body">
                        <h1>My Order</h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Order Date</th>
                                <th>Order Total</th>
                                <th>Order Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>{{ $order->order_total }}</td>
                                <td>{{ $order->order_status }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
