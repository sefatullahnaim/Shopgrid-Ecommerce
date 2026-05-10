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
                <li class="breadcrumb-item active" aria-current="page">Manage Sub Category</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title">All Sub Category Info</h3>
                </div>
                <div class="card-body">
                    <p class="text-danger"> {{ session('success') }} </p>
                    <p class="text-success"> {{ session('updated') }} </p>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                            <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">SL NO</th>
                                <th class="wd-15p border-bottom-0">Category Name</th>
                                <th class="wd-15p border-bottom-0">Sub Category Name</th>
                                <th class="wd-20p border-bottom-0">Description</th>
                                <th class="wd-15p border-bottom-0">Image</th>
                                <th class="wd-10p border-bottom-0">Status</th>
                                <th class="wd-25p border-bottom-0">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($subCategories as $subCategory)
                                    <tr>
                                        <td class=" text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $subCategory->category->name }}</td>
                                        <td>{{ $subCategory->name }}</td>
                                        <td>{{ $subCategory->description }}</td>
                                        <td class=" text-center"><img src="{{ asset('storage/' . $subCategory->image) }}"
                                                width="60" height="auto"></td>
                                        <td class=" text-center">{{ $subCategory->status == 1 ? 'Published' : 'Unpublished' }}
                                        </td>
                                        <td class="text-center">
                                            <div style="display: flex; justify-content: center; gap: 5px;">

                                                <!-- Edit Button -->
                                                <a href="{{ route('sub-categories.edit', $subCategory->id) }}"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('sub-categories.destroy', $subCategory->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
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
