@extends('client.myAccount.navAcc')
@section('navMy')
    <div id="change-password" class="content-section">
        <h1 class="title-head">Đổi mật khẩu</h1>
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
                            <form method="POST" action="{{ route('user.changePassword') }}"
                                id="yourFormID change_customer_password" accept-charset="UTF-8">
                                @csrf
                                <p>
                                    Để đảm bảo tính bảo mật vui lòng đặt mật khẩu với ít nhất 8 kí tự
                                </p>
                                <div class="form-signup clearfix">
                                    <fieldset class="form-group">
                                        <label for="current_password">Mật khẩu cũ <span class="error">*</span></label>
                                        <a href="{{ route('forgot-password') }}" class="text-muted">Quên mật khẩu?</a>
                                        <input type="password" placeholder="Mật khẩu cũ" name="current_password"
                                            class="form-control form-control-lg">
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="new_password">Mật khẩu mới <span class="error">*</span></label>
                                        <input type="password" placeholder="Mật khẩu mới" name="new_password"
                                            class="form-control form-control-lg">
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="new_password_confirmation">Xác nhận lại mật khẩu <span
                                                class="error">*</span></label>
                                        <input type="password" placeholder="Xác nhận lại mật khẩu"
                                            name="new_password_confirmation" class="form-control form-control-lg">
                                    </fieldset>
                                    <button type="submit"
                                        class="button btn-edit-addr btn btn-blues btn-more margin-top-15"><i
                                            class="hoverButton"></i>Đặt lại mật khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
