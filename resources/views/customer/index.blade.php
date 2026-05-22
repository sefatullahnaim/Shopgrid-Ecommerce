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
                        <li>Dashboard</li>
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
                        <h1>Hello {{ Session::get('customer_name') }}</h1>

                        <h2>My Dashboard</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
