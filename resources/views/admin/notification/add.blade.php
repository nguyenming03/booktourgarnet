@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Thêm Thông Báo</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home-admin') }}">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Thêm thông báo</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('notifications.store') }}" method="post">
                                @csrf

                                <div class="mb-3">
                                    <label for="title" class="form-label">Tiêu đề thông báo<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="title" name="title" class="form-control"
                                        placeholder="Nhập tiêu đề thông báo" value="{{ old('title') }}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Nội dung thông báo</label>
                                    <input type="text" id="content" name="content" class="form-control"
                                        placeholder="Nhập nội dung thông báo" value="{{ old('content') }}">
                                    @error('content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="all_user" class="form-label">Cấu hình thông báo<span
                                            class="text-danger">*</span></label>
                                    <select name="all_user" class="form-select" id="all_user">
                                        <option value="1" {{ old('all_user') == 1 ? 'selected' : '' }}>Tới tất cả người
                                            dùng</option>
                                        <option value="0" {{ old('all_user') == 0 ? 'selected' : '' }}>Tùy chọn
                                        </option>
                                    </select>
                                    @error('all_user')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label">Loại thông báo</label>
                                    <input type="text" id="type" name="type" class="form-control"
                                        placeholder="Nhập loại thông báo. VD: voucher, tour, alert, system"
                                        value="{{ old('type') }}">
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Trạng thái<span
                                            class="text-danger">*</span></label>
                                    <select name="is_active" class="form-select" id="is_active">
                                        <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Hiển thị
                                        </option>
                                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Ẩn</option>
                                    </select>
                                    @error('is_active')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-mb-12">
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="submit">Thêm mới</button>
                                        <a href="{{ route('notifications.index') }}" class="btn btn-danger">Hủy</a>
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
