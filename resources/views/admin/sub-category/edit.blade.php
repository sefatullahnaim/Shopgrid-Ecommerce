@extends('admin.master')

@section('body')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Sub Category Module</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Sub Category</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Sub Category</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- row -->
    <div class="row row-deck">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title">Edit Sub Category Form</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted"> {{ session('success') }} </p>
                    <form class="form-horizontal" action="{{ route('sub-categories.update', $subCategory->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <label for="name" class="col-md-3 form-label">Category Name</label>
                            <div class="col-md-9">
                                <select class="form-control" name="category_id">
                                    <option value=""> -- Select Category -- </option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"  @selected($category->id == $subCategory->category_id)> {{$category->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="name" class="col-md-3 form-label">Sub Category Name</label>
                            <div class="col-md-9">
                                <input class="form-control" id="name" value="{{ $subCategory->name }}" placeholder="Enter Sub Category Name" name="name" type="text"/>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="description" class="col-md-3 form-label">Sub Category Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="description" name="description" placeholder="Enter Sub Category Description">{{ $subCategory->description }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="image" class="col-md-3 form-label">Sub Category Image</label>
                            <div class="col-md-9">
                                <input class="form-control" id="image" name="image" type="file"/>
                                <img src="{{asset('storage/' . $subCategory->image)}}" alt="" height="100"/>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Publication Status</label>
                            <div class="col-md-9">
                                <label><input value="1" name="status" type="radio" {{$subCategory->status == 1 ? 'checked' : ''}}> Published</label>
                                <label><input value="0" name="status" type="radio" {{$subCategory->status == 0 ? 'checked' : ''}}> Unpublished</label>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update Sub Category Info</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
@endsection
