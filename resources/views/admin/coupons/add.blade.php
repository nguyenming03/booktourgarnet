@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Danh Sách Phiếu Giảm Giá</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Thêm mã giảm giá</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('coupons.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên phiếu giảm giá<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                                class="form-control" placeholder="Nhập câu trả lời">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Mã<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="code" name="code" value="{{ old('code') }}"
                                                class="form-control" placeholder="Nhập câu trả lời">
                                            @error('code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Loại mã giảm giá<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="type" name="type" value="{{ old('type') }}"
                                                class="form-control" placeholder="Loại mã giảm giá">
                                            @error('type')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="number" class="form-label">Số lượng<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="number" name="number" value="{{ old('number') }}"
                                                class="form-control" placeholder="Nhập số lượng mã giảm giá">
                                            @error('number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">Ngày Bắt Đầu<span
                                                    class="text-danger">*</span></label>
                                            <input type="datetime-local" id="start_date" name="start_date"
                                                value="{{ old('start_date') }}" class="form-control"
                                                placeholder="Nhập câu trả lời">
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="percentage_price" class="form-label">Tỷ Lệ Giảm Giá<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="percentage_price" name="percentage_price"
                                                value="{{ old('percentage_price') }}" class="form-control"
                                                placeholder="Nhập câu trả lời">
                                            @error('percentage_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">Ngày Kết Thúc<span
                                                    class="text-danger">*</span></label>
                                            <input type="datetime-local" id="end_date" name="end_date"
                                                value="{{ old('end_date') }}" class="form-control"
                                                placeholder="Nhập câu trả lời">
                                            @error('end_date')
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
                                                <option value="1">Hiển Thị</option>
                                                <option value="0">Ẩn</option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status1" class="form-label">Tour<span
                                                    class="text-danger">*</span></label>
                                            <select name="tour_id" class="form-select w-100" id="status1">
                                                <option value="">Chọn tour</option>
                                                @foreach ($listTour as $status)
                                                    <option value="{{ $status->id }}"
                                                        {{ old('tour_id') == $status->id ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tour_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-bottom: 10px">
                                        <div class="text-end">
                                            <button class="btn btn-primary" type="submit">Thêm mới</button>
                                            <a href="{{ route('coupons.index') }}" class="btn btn-danger">Hủy</a>
                                        </div>
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
