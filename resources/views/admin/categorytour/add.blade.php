@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Quản Lý mục tour</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"> <a href="{{ route('categorytour.index') }}">Trang quản trị</a>
                                </li>
                                <li class="breadcrumb-item active">Thêm mới danh mục tour</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('categorytour.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                {{-- <div class="mb-3">
                                    <label for="img_thumb" class="form-label">Hình Ảnh</label>
                                    <input type="file" id="img_thumb" name="img_thumb" class="form-control"
                                        onchange="showImage(event)">
                                    <img id="img_danh_muc" src="" alt="Hình Ảnh" style="width: 150px;display:none">
                                </div> --}}

                                <div class="mb-3">
                                    <label for="category_tour" class="form-label">Tên danh mục tour<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="category_tour" name="category_tour"
                                        value="{{ old('category_tour') }}" class="form-control" onkeyup="generateSlug()"
                                        placeholder="Nhập tên danh mục tour...">
                                    @error('category_tour')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="description">Mô tả ngắn</label>
                                    <textarea class="form-control" id="description" name="description" value="{{ old('description') }}" rows="2"
                                        placeholder="Nhập mô tả danh mục tour..."></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="slug">Slug</label>
                                    <textarea class="form-control" id="slug" name="slug" value="{{ old('slug') }}" rows="2"
                                        placeholder="Nhập mô tả danh mục tour..."></textarea>
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="responsibility">Trách nhiệm</label>
                                    <textarea class="form-control" id="responsibility" name="responsibility" value="{{ old('responsibility') }}"
                                        rows="2" placeholder="Nhập mô tả danh mục tour..."></textarea>
                                    @error('responsibility')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


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

                                <div class="mb-3 text-end">
                                    <button class="btn btn-primary" type="submit">Thêm mới</button>
                                    <a href="{{ route('categorytour.index') }}" class="btn btn-danger">Huỷ</a>
                                </div>

                            </form>
                        </div>
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
            var category_tour = document.getElementById('category_tour').value;


            var slug = slugify(category_tour, {
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
    {{-- Thêm album ảnh --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var rowCount = 1;

            document.getElementById('add-row').addEventListener('click', function() {
                var tableBody = document.getElementById('image-table-body');
                var newRow = document.createElement('tr');
                newRow.innerHTML = `
         <td class="d-flex align-item-center">
        <img id="preview_${rowCount}" src="https://static.vecteezy.com/system/resources/previews/000/420/681/original/picture-icon-vector-illustration.jpg" alt="Hình Ảnh SẢn Phẩm"
        style="width: 50px" class="me-3">
        <input type="file" id="hinh_anh" name="list_hinh_anh[id_${rowCount}]" class="form-control"
        onchange="previewImage(this,${rowCount})">
    
    
    
    </td>
    <td>
        <i 
            class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1" style="cursor: pointer" onclick="removeRow(this)"></i>
    </td>`;
                tableBody.appendChild(newRow);
                rowCount++;

            })



        });

        function previewImage(input, rowIndex) {

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById(`preview_${rowIndex}`).setAttribute('src', e.target.result)


                }

                reader.readAsDataURL(input.files[0]);

            }

        }

        function removeRow(item) {
            var row = item.closest('tr');
            row.remove();
        }
        CKEDITOR.replace('content');
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: '/upload-image?_token={{ csrf_token() }}', // URL để xử lý upload ảnh
                },
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                    'blockQuote', '|', 'insertTable', 'uploadImage', '|', 'undo', 'redo'
                ],
                image: {
                    toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side'],
                },
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script src="https:////cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
@endsection
@section('script')
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
    {{-- Thêm album ảnh --}}
    <script>
        document.addEventListener('DOMDescriptionLoaded', function() {

            var rowCount = 1;

            document.getElementById('add-row').addEventListener('click', function() {
                var tableBody = document.getElementById('image-table-body');
                var newRow = document.createElement('tr');
                newRow.innerHTML = `
         <td class="d-flex align-item-center">
        <img id="preview_${rowCount}" src="https://static.vecteezy.com/system/resources/previews/000/420/681/original/picture-icon-vector-illustration.jpg" alt="Hình Ảnh SẢn Phẩm"
        style="width: 50px" class="me-3">
        <input type="file" id="hinh_anh" name="list_hinh_anh[id_${rowCount}]" class="form-control"
        onchange="previewImage(this,${rowCount})">
    
    
    
    </td>
    <td>
        <i 
            class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1" style="cursor: pointer" onclick="removeRow(this)"></i>
    </td>`;
                tableBody.appendChild(newRow);
                rowCount++;

            })



        });

        function previewImage(input, rowIndex) {

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById(`preview_${rowIndex}`).setAttribute('src', e.target.result)


                }

                reader.readAsDataURL(input.files[0]);

            }

        }

        function removeRow(item) {
            var row = item.closest('tr');
            row.remove();
        }
        CKEDITOR.replace('description');
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: '/upload-image?_token={{ csrf_token() }}', // URL để xử lý upload ảnh
                },
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                    'blockQuote', '|', 'insertTable', 'uploadImage', '|', 'undo', 'redo'
                ],
                image: {
                    toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side'],
                },
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script src="https:////cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
@endsection
