@extends('admin.master')

@section('body')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Order Invoice</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Apps</li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Order Invoice</a></li>
                <li class="breadcrumb-item active" aria-current="page">Invoice Details</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-start">
                            <h3 class="card-title mb-0">#INV-00{{$order->id}}</h3>
                        </div>
                        <div class="float-end">
                            <h3 class="card-title">Date: {{ $order->order_date }}</h3>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 ">
                            <p class="h3">Invoice Form:</p>
                            <address>
                                Street, Line<br>
                                State, City<br>
                                Country, Postal Code<br>
                                invoice@spruko.com
                            </address>
                        </div>
                        <div class="col-lg-6 text-end">
                            <p class="h3">Invoice To:</p>
                            <address>
                                {{$order->customer->name}}<br>
                                {{$order->customer->email}}<br>
                                {{$order->customer->mobile}}<br>
                                {{$order->delivery_address}}
                            </address>
                        </div>
                    </div>
                    <div class="table-responsive push">
                        <table class="table table-bordered table-hover mb-0 text-nowrap border-bottom">
                            <tbody><tr class=" ">
                                <th class="text-center">SL NO</th>
                                <th style="width: 20%; word-wrap: inherit;">Item Info</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Sub Total</th>
                            </tr>
                            @php($sum=0)
                            @foreach($order->orderDetail as $orderDetail)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td style="width: 20%; word-wrap: inherit;">
                                    <p class="font-w600 mb-1">{{ substr($orderDetail->product_name, 0, 70) }}</p>
                                </td>
                                <td class="text-center">{{$orderDetail->product_qty}}</td>
                                <td class="text-end">{{$orderDetail->product_price}}</td>
                                <td class="text-end">{{$orderDetail->product_qty * $orderDetail->product_price}}</td>
                            </tr>
                            @php($sum=$sum+($orderDetail->product_qty * $orderDetail->product_price))
                            @endforeach
                            <tr>
                                <td colspan="4" class="fw-bold text-uppercase text-end">Item Total</td>
                                <td class="fw-bold text-end h4">{{$sum}}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="fw-bold text-uppercase text-end">Tax Total (15%)</td>
                                <td class="fw-bold text-end h4">{{ $tax = round( ($sum*0.15) ) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="fw-bold text-uppercase text-end">Shipping Total (15%)</td>
                                <td class="fw-bold text-end h4">{{ $shipping = 100 }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="fw-bold text-uppercase text-end">Total Payable</td>
                                <td class="fw-bold text-end h4">{{ $shipping + $tax + $sum }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="button" class="btn btn-primary mb-1" onclick="javascript:window.print();"><i class="si si-wallet"></i> Pay Invoice</button>
                    <button type="button" class="btn btn-success mb-1" onclick="javascript:window.print();"><i class="si si-paper-plane"></i> Send Invoice</button>
                    <button type="button" class="btn btn-info mb-1" onclick="javascript:window.print();"><i class="si si-printer"></i> Print Invoice</button>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- ROW-1 CLOSED -->

@endsection


