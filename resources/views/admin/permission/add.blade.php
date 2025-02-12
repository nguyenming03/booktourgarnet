@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Thêm quyền</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home-admin') }}">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Thêm quyền</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form class="col-6" action="{{ route('permissions.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Tên quyền<span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control"
                        placeholder="Nhập tên quyền">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả quyền</label>
                    <input type="text" id="description" name="description" value="{{ old('description') }}" class="form-control"
                        placeholder="Nhập mô tả quyền">
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <a href="{{ route('permissions.index') }}" class="btn btn-info">trở về</a>
                    <button class="btn btn-primary" type="submit">Thêm mới</button>
                </div>

            </form>
        </div>
    </div>
@endsection
