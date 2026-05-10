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
                <li class="breadcrumb-item active" aria-current="page">Create New Product</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- row -->
    <div class="row row-deck">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title">Create Product Form</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted"> {{ session('message') }} </p>
                    <form class="form-horizontal" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <label for="name" class="col-md-3 form-label">Category Name</label>
                            <div class="col-md-9">
                                <select class="form-control" name="category_id" onchange="getSubCategoryByCategoryId(this.value)">
                                    <option value=""> -- Select Category -- </option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}"> {{$category->name}} </option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{ $errors->has('category_id') ? $errors->first('category_id') : '' }}</p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="name" class="col-md-3 form-label">Sub Category Name</label>
                            <div class="col-md-9">
                                <select class="form-control" name="sub_category_id" id="subCategoryId">
                                    <option value=""> -- Select Sub Category -- </option>
                                    @foreach($sub_categories as $sub_category)
                                        <option value="{{$sub_category->id}}"> {{$sub_category->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="name" class="col-md-3 form-label">Brand Name</label>
                            <div class="col-md-9">
                                <select class="form-control" name="brand_id">
                                    <option value=""> -- Select Brand -- </option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}"> {{$brand->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="name" class="col-md-3 form-label">Unit Name</label>
                            <div class="col-md-9">
                                <select class="form-control" name="unit_id">
                                    <option value=""> -- Select Unit -- </option>
                                    @foreach($units as $unit)
                                        <option value="{{$unit->id}}"> {{$unit->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="name" class="col-md-3 form-label">Product Name</label>
                            <div class="col-md-9">
                                <input class="form-control" id="name" placeholder="Enter Product Name" name="name" type="text"/>
                                <p class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="code" class="col-md-3 form-label">Product Code</label>
                            <div class="col-md-9">
                                <input class="form-control" id="code" placeholder="Enter Product Code" name="code" type="text"/>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="slug" class="col-md-3 form-label">Product Slug</label>
                            <div class="col-md-9">
                                <input class="form-control" id="slug" placeholder="Enter Product Slug" name="slug" type="text"/>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="stock" class="col-md-3 form-label">Product Stock</label>
                            <div class="col-md-9">
                                <input class="form-control" id="stock" placeholder="Enter Product Stock" name="stock" type="text"/>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="" class="col-md-3 form-label">Product Price</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="regular_price" placeholder="Product Regular Price"/>
                                    <input type="number" class="form-control" name="selling_price" placeholder="Product Selling Price"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="shortDescription" class="col-md-3 form-label">Short Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="shortDescription" name="short_description" placeholder="Enter Short Description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="summernote" class="col-md-3 form-label">Long Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="summernote" name="long_description" placeholder="Enter Long Description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="metaTitle" class="col-md-3 form-label">Meta Title</label>
                            <div class="col-md-9">
                                <input class="form-control" id="metaTitle" placeholder="Enter Meta Title" name="meta_title" type="text"/>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="metaKeyword" class="col-md-3 form-label">Meta Keyword</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="metaKeyword" name="meta_keyword" placeholder="Enter Meta Keyword"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="metaDescriptiond" class="col-md-3 form-label">Meta Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="metaDescriptiond" name="meta_description" placeholder="Enter Meta Description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="image" class="col-md-3 form-label">Product Image</label>
                            <div class="col-md-9">
                                <input class="form-control" id="image" name="image" type="file">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="otherImage" class="col-md-3 form-label">Product Other Image</label>
                            <div class="col-md-9">
                                <input class="form-control" id="otherImage" name="other_image[]" multiple type="file"/>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Featured Status</label>
                            <div class="col-md-9">
                                <label><input value="1" name="featured_status" type="radio" checked> Featured</label>
                                <label><input value="0" name="featured_status" type="radio"> Not Featured</label>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Publication Status</label>
                            <div class="col-md-9">
                                <label><input value="1" name="status" type="radio" checked> Published</label>
                                <label><input value="0" name="status" type="radio"> Unpublished</label>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Create New Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
@endsection
