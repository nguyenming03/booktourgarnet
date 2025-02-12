@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Danh Sách Câu Hỏi</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home-admin') }}">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Cập nhật câu hỏi</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form class="col-6" action="{{ route('permissions.update', $permission) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="name" class="form-label">Tên quyền<span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" value="{{ $permission->name }}" class="form-control"
                        placeholder="Nhập tên quyền">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả quyền</label>
                    <input type="text" id="description" name="description" value="{{ $permission->description }}" class="form-control"
                        placeholder="Nhập mô tả quyền">
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <a href="{{route('permissions.index')}}" class="btn btn-info">Trở về</a>
                    <button class="btn btn-primary" type="submit">Cập nhật</button>
                </div>

            </form>
        </div>
    </div>
@endsection
