@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Quản Lý Địa Điểm</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"> <a href="{{ route('location.index') }}">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Thêm địa điểm</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('location.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Hình ảnh</label>

                                        <input type="file" id="image" name="image" class="form-control"
                                            onchange="showImage(event)">
                                        <img id="img_danh_muc" src="" alt="Hình Ảnh Sản Phẩm"
                                            style="width: 150px;display:none">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên địa điểm<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                                onkeyup="generateSlug()" class="form-control" placeholder="Nhập địa điểm">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="slug" class="form-label">slug<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="slug"name="slug" value="{{ old('slug') }}"
                                                class="form-control" placeholder="Nhập địa điểm">
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
                                                value="{{ old('description') }}" class="form-control"
                                                placeholder="Nhập câu trả lời">
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Nội dung<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="content" name="content" value="{{ old('content') }}"
                                                class="form-control" placeholder="Nhập câu trả lời">
                                            @error('content')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6" hidden>
                                        <div class="mb-3">
                                            <label for="status1" class="form-label">User<span
                                                    class="text-danger">*</span></label>
                                            <select name="user_id" class="form-select w-100" id="status1">
                                                @foreach ($listUser as $status)
                                                    <option value="{{ $status->id }}"
                                                        {{ old('user_id') == $status->id ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
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
                                                <option value="1">Hiển Thị</option>
                                                <option value="0">Ẩn</option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="margin-bottom: 10px">
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="submit">Thêm mới</button>
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
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/slugify@1.4.7/slugify.min.js"></script>
    <script>
        function generateSlug() {
            var name = document.getElementById('name').value;


            var slug = slugify(name, {
                lower: true,
                replacement: '-',
                remove: /[*+~.()'"!:@]/g
            });

            document.getElementById('slug').value = slug;
        }
    </script>
    <script>
        function showImage(event) {
            const img_danh_muc = document.getElementById('img_danh_muc');

            const file = event.target.files[0];

            const reader = new FileReader();

            reader.onload = function() {
                img_danh_muc.src = reader.result;
                img_danh_muc.style.display = 'block';


            }
            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
