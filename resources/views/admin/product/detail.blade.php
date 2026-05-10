@extends('admin.master')

@section('body')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Product Module</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product Detail</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title"> Product Detail Info</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted"> {{ session('message') }} </p>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                            <tr>
                                <th>Product ID</th>
                                <td>{{ $product->id }}</td>
                            </tr>
                            <tr>
                                <th>Product Category</th>
                                <td>{{ $product->category->name }}</td>
                            </tr>
                            <tr>
                                <th>Product Sub Category</th>
                                <td>{{ $product->subCategory->name }}</td>
                            </tr>
                            <tr>
                                <th>Product Brand</th>
                                <td>{{ $product->brand->name }}</td>
                            </tr>
                            <tr>
                                <th>Product Unit</th>
                                <td>{{ $product->unit->name }}</td>
                            </tr>
                            <tr>
                                <th>Product Name</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>Product Code</th>
                                <td>{{ $product->code }}</td>
                            </tr>
                            <tr>
                                <th>Product Slug</th>
                                <td>{{ $product->slug }}</td>
                            </tr>
                            <tr>
                                <th>Product Stock</th>
                                <td>{{ $product->stock }}</td>
                            </tr>
                            <tr>
                                <th>Product Price</th>
                                <td>
                                  <b>Regular Price : </b>  {{ $product->regular_price }}, <b>Selling Price : </b>  {{ $product->selling_price }}
                                </td>
                            </tr>
                            <tr>
                                <th>Product Short Description</th>
                                <td>{{ $product->short_description }}</td>
                            </tr>
                            <tr>
                                <th>Product Long Description</th>
                                <td>{!! $product->long_description !!}</td>
                            </tr>
                            <tr>
                                <th>Meta Title</th>
                                <td>{{ $product->meta_title }}</td>
                            </tr>
                            <tr>
                                <th>Meta Keyword</th>
                                <td>{{ $product->meta_keyword }}</td>
                            </tr>
                            <tr>
                                <th>Meta Description</th>
                                <td>{{ $product->meta_description }}</td>
                            </tr>
                            <tr>
                                <th>Meta Description</th>
                                <td>{{ $product->meta_description }}</td>
                            </tr>
                            <tr>
                                <th>Product Image</th>
                                <td><img src="{{ asset('storage/'.$product->image) }}" alt="" height="100"/></td>
                            </tr>
                            <tr>
                                <th>Product Other Image</th>
                                <td>
                                    @foreach($product->productImages as $productImage)
                                    <img src="{{asset('storage/'.$productImage->image)}}" class=" m-2 " alt="" height="60"/>
                                @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Featured Status</th>
                                <td>{{ $product->featured_status == 1 ? 'Featured' : 'Not Featured' }}</td>
                            </tr>
                            <tr>
                                <th>Publication Status</th>
                                <td>{{ $product->status == 1 ? 'Published' : 'Not Published' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection
