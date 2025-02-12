@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Sửa Dịch Vụ</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Dịch Vụ</a></li>
                                <li class="breadcrumb-item active">Sửa Dịch Vụ</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('service.update', $service->id) }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên dịch vụ<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ $service->name }}"
                                        class="form-control" placeholder="Nhập tên dịch vụ">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá
                                        <span class="text-danger">*</span></label>
                                    <input type="number" id="price" name="price" value="{{ $service->price }}"
                                        class="form-control" placeholder="Nhập giá">
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Nhập mô tả
                                        <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control" rows="10" placeholder="Nhập mô tả">{{ $service->description }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Chọn danh mục
                                        <span class="text-danger">*</span></label>
                                    <select name="category_service_id" id="category_service_id" class="form-control">
                                        <option value="">Chọn danh mục</option>
                                        @foreach ($category_services as $category_service)
                                            <option value="{{ $category_service->id }} "
                                                {{ $service->category_service_id == $category_service->id ? 'selected' : '' }}>
                                                {{ $category_service->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_service_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12" style="margin-bottom: 10px">
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="submit">Cập Nhật</button>
                                        <a href="{{ route('service.index') }}" class="btn btn-danger">Hủy</a>
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
