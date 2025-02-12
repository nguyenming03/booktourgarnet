@extends('client.myAccount.navAcc')
@section('navMy')
    <div id="change-password" class="content-section">
        <h1 class="title-head">Cập nhật tài khoản</h1>
        <div class="my-account">
            <div class="dashboard">
                <div class="recent-orders">
                    <div class="table-responsive tab-all">
                        <div class="page-login">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible" role="alert" id="successAlert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Thành công!</strong> {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Lỗi!</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <script>
                                setTimeout(function() {
                                    $('#successAlert').fadeOut('slow');
                                }, 3000);
                                setTimeout(function() {
                                    $('#errorAlert').fadeOut('slow');
                                }, 3000);
                            </script>
                            <form action="{{ route('my-account.update', Auth::id()) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Họ và Tên:</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Số Điện Thoại:</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $user->phone }}">
                                </div>

                                <div class="form-group">
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ $user->address }}">
                                </div>

                                <div class="form-group">
                                    <label for="avatar">Ảnh đại diện:</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar">
                                </div>

                                <div class="form-group">
                                    <label for="birth">Ngày Sinh:</label>
                                    <input type="date" class="form-control" id="birth" name="birth"
                                        value="{{ $user->birth }}">
                                </div>

                                <div class="form-group">
                                    <label>Giới tính:</label>
                                    <select class="form-control" name="gender">
                                        <option value="nam" {{ $user->gender == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="nu" {{ $user->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Cập nhật</button>
                                <a href="{{route('my-account.index')}}" class="btn btn-primary">Quay lại</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
