@extends('admin.layouts.app')

@section('style')
    <!-- Thêm CSS của Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Gán thông báo</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home-admin') }}">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Gán thông báo</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('notification-user.store') }}" method="post">
                                @csrf

                                <div class="mb-3">
                                    <label for="notification_id" class="form-label">Chọn thông báo</label>
                                    <select name="notification_id" class="form-select" id="notification_id" required>
                                        <option value="">Chọn thông báo</option>
                                        @foreach ($notifications as $notification)
                                            <option value="{{ $notification->id }}">{{ $notification->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('notification_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Chọn người nhận</label>
                                    <select name="user_id[]" class="form-select" id="user_id" multiple="multiple"
                                        required>
                                        <option value="">Tìm kiếm người dùng</option>
                                    </select>
                                    @error('user_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <a href="{{ route('notification-user.index') }}" class="btn btn-info">trở về</a>
                                    <button class="btn btn-primary" type="submit">Gán thông báo</button>
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
    <script>
        // Khởi tạo Select2 cho dropdown chọn nhiều người nhận
        $(document).ready(function() {
            $('#user_id').select2({
                placeholder: 'Tìm kiếm người dùng',
                allowClear: true,
                multiple: true, // Cho phép chọn nhiều người dùng
                ajax: {
                    url: '{{ route('users.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // Từ khóa tìm kiếm
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(user) {
                                return {
                                    id: user.id,
                                    text: user.name
                                };
                            })
                        };
                    }
                }
            });
        });
    </script>

    <!-- Thêm JS của Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection
