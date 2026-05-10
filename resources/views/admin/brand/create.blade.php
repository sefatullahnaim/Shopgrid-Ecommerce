@extends('admin.master')

@section('body')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Brand Module</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Brand</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create New Brand</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- row -->
    <div class="row row-deck">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title">Create Brand Form</h3>
                </div>
                <div class="card-body">
                    <p class="text-success text-center"> {{ session('message') }} </p>
                    <form class="form-horizontal" action="{{ route('brands.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <label for="name" class="col-md-3 form-label">Brand Name</label>
                            <div class="col-md-9">
                                <input class="form-control" id="name" placeholder="Enter Brand Name" name="name" type="text"/>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="description" class="col-md-3 form-label">Brand Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="description" name="description" placeholder="Enter Brand Description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="image" class="col-md-3 form-label">Brand Image</label>
                            <div class="col-md-9">
                                <input class="form-control" id="image" name="image" type="file">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Publication Status</label>
                            <div class="col-md-9">
                                <label><input value="1" name="status" type="radio" checked> Published</label>
                                <label><input value="0" name="status" type="radio"> Unpublished</label>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Create New Brand</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
@endsection

