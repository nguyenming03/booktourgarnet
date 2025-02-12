@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Sửa Địa Điểm</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"> <a href="{{ route('location.index') }}">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Sửa địa điểm</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('location.update', $location->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Hình ảnh</label>

                                        <input type="file" id="image" name="image" class="form-control"
                                            onchange="showImage(event)">
                                        <img id="img_danh_muc" src="{{ Storage::url($location->image) }}"
                                            alt="Hình Ảnh Sản Phẩm" style="width: 150px;display:none">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên địa điểm<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="name" name="name"
                                                value="{{ $location->name }}" value="{{ old('name') }}"
                                                class="form-control" placeholder="Nhập tên địa điểm...">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Slug<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="slug"name="slug" value="{{ $location->slug }}"
                                                value="{{ old('slug') }}" class="form-control" placeholder="">
                                            @error('slug')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Mô tả<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="description" name="description"
                                                value="{{ $location->description }}" value="{{ old('description') }}"
                                                class="form-control" placeholder="Nhập mô tả...">
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Nội dung<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="content" name="content"
                                                value="{{ $location->content }}" value="{{ old('content') }}"
                                                class="form-control" placeholder="Nhập nội dung...">
                                            @error('content')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6" hidden>
                                        <div class="mb-3 ">
                                            <label for="status1" class="form-label">User<span
                                                    class="text-danger">*</span></label>
                                            <select name="user_id" class="form-select w-100" id="status1">
                                                @foreach ($listUser as $status)
                                                    <option value="{{ $status->id }}"
                                                        {{ $location->user_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status1" class="form-label">Trạng Thái<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="status1" name="status">
                                                <option value="">Trạng Thái</option>
                                                <option value="1" {{ $location->status == '1' ? 'selected' : '' }}>
                                                    Hiển
                                                    Thị
                                                </option>
                                                <option value="0" {{ $location->status == '0' ? 'selected' : '' }}>Ẩn
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-12" style="margin-bottom: 10px">
                                        <div class="text-end">
                                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                                            <a href="{{ route('location.index') }}" class="btn btn-danger">Hủy</a>
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
