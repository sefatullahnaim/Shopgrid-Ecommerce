@extends('admin.master')

@section('body')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Order Module</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Order</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Order</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title">All Order Info</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted"> {{ session('message') }} </p>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                            <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">SL NO</th>
                                <th class="wd-15p border-bottom-0">Order Id</th>
                                <th class="wd-20p border-bottom-0">Customer Info</th>
                                <th class="wd-20p border-bottom-0">Order Date</th>
                                <th class="wd-15p border-bottom-0">Order Total</th>
                                <th class="wd-10p border-bottom-0">Order Status</th>
                                <th class="wd-25p border-bottom-0">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->customer->name. '('.$order->customer->mobile.')'}}</td>
                                    <td>{{$order->order_date}}</td>
                                    <td>{{$order->order_total}}</td>
                                    <td>{{$order->order_status}}</td>
                                    <td>
                                        <a href="{{ route('admin.order.detail', $order->id)}}" title="Order Detail View" class="btn btn-info btn-sm">
                                            <i class="fa fa-book"></i>
                                        </a>
                                        <a href="{{ route('admin.order.edit', $order->id)}}" title="Order Edit" class="btn btn-success btn-sm {{$order->order_status == 'Complete' ? 'disabled' : ''}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.order.invoice', $order->id)}}" title="Order Invoice View" class="btn btn-primary btn-sm">
                                            <i class="fa fa-paper-plane"></i>
                                        </a>
                                        <a href="{{ route('admin.order.invoice.download', $order->id)}}" title="Order Invoice Download" class="btn btn-warning btn-sm">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <a href="{{ route('admin.order.delete', $order->id)}}" title="Order Delete" class="btn btn-danger btn-sm {{$order->order_status == 'Cancel' ? '' : 'disabled'}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection
