@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Sửa Danh Mục Dịch Vụ</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('category_service.index') }}">Danh Mục Dịch
                                        Vụ</a></li>
                                <li class="breadcrumb-item active">Sửa Danh Mục Dịch Vụ</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('category_service.update', $category_services->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Tên danh mục dịch vụ<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="category_name" name="category_name"
                                        value="{{ $category_services->category_name }}" class="form-control"
                                        placeholder="Nhập tên danh mục dịch vụ">
                                    @error('category_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12" style="margin-bottom: 10px">
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="submit">Cập Nhật</button>
                                        <a href="{{ route('category_service.index') }}" class="btn btn-danger">Hủy</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
