@extends('client.layouts.app')
@section('title')
   Đăng Ký
@endsection
@section('style')
@endsection

@section('content')
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="home" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="../index.html" title="Trang chủ">
                                <span itemprop="name">Trang chủ</span>
                                <meta itemprop="position" content="1" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>

                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <strong itemprop="name">Đăng ký tài khoản</strong>
                            <meta itemprop="position" content="2" />
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container mr-bottom-20">
        <h1 class="title-head text-center">Đăng ký tài khoản</h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="page-login">
                    <div id="login">
                        <div class="text-center"><span>Nếu chưa có tài khoản vui lòng đăng ký tại đây</span></div>
                        <div class="social-login text-center margin-bottom-10 margin-top-15">
                            {{-- @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif --}}
                            {{-- <script>
                                function loginFacebook() {
                                    var a = {
                                            client_id: "947410958642584",
                                            redirect_uri: "https://store.mysapo.net/account/facebook_account_callback",
                                            state: JSON.stringify({
                                                redirect_url: window.location.href
                                            }),
                                            scope: "email",
                                            response_type: "code"
                                        },
                                        b = "https://www.facebook.com/v3.2/dialog/oauth" + encodeURIParams(a, !0);
                                    window.location.href = b
                                }

                                function loginGoogle() {
                                    var a = {
                                            client_id: "997675985899-pu3vhvc2rngfcuqgh5ddgt7mpibgrasr.apps.googleusercontent.com",
                                            redirect_uri: "https://store.mysapo.net/account/google_account_callback",
                                            scope: "email profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile",
                                            access_type: "online",
                                            state: JSON.stringify({
                                                redirect_url: window.location.href
                                            }),
                                            response_type: "code"
                                        },
                                        b = "https://accounts.google.com/o/oauth2/v2/auth" + encodeURIParams(a, !0);
                                    window.location.href = b
                                }

                                function encodeURIParams(a, b) {
                                    var c = [];
                                    for (var d in a)
                                        if (a.hasOwnProperty(d)) {
                                            var e = a[d];
                                            null != e && c.push(encodeURIComponent(d) + "=" + encodeURIComponent(e))
                                        } return 0 == c.length ? "" : (b ? "?" : "") + c.join("&")
                                }
                            </script>
                            <a href="javascript:void(0)" class="social-login--facebook" onclick="loginFacebook()"><img
                                    width="129px" height="37px" alt="facebook-login-button"
                                    src="http://bizweb.dktcdn.net/assets/admin/images/login/fb-btn.svg"></a>
                            <a href="javascript:void(0)" class="social-login--google" onclick="loginGoogle()"><img
                                    width="129px" height="37px" alt="google-login-button"
                                    src="http://bizweb.dktcdn.net/assets/admin/images/login/gp-btn.svg"></a>
                        </div>
                        <form method="post" action="https://ant-du-lich.mysapo.net/account/register" id="customer_register"
                            accept-charset="UTF-8"><input name="FormType" type="hidden" value="customer_register" /><input
                                name="utf8" type="hidden" value="true" /><input type="hidden"
                                id="Token-22b3be00dbc5450788f2beb6110b1b1f" name="Token" />
                            <script src="../../www.google.com/recaptcha/apif78f.js?render=6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK"></script>
                            <script>
                                grecaptcha.ready(function() {
                                    grecaptcha.execute("6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK", {
                                        action: "customer_register"
                                    }).then(function(token) {
                                        document.getElementById("Token-22b3be00dbc5450788f2beb6110b1b1f").value = token
                                    });
                                });
                            </script> --}}
                            {{-- <div class="form-signup"> --}}

                        </div>
                        <div class="form-signup clearfix">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="row">
                                        <form id="registerForm" action="{{ route('post-dang-ky') }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <div class="col-md-12">
                                                <fieldset class="form-group">
                                                    <label>Họ<span class="required">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        name="lastName" id="lastName"
                                                        data-validation-error-msg="Không được để trống"
                                                        data-validation="required">
                                                    @error('lastName')
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                            <div class="col-md-12">
                                                <fieldset class="form-group">
                                                    <label>Tên<span class="required">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        name="firstName" id="firstName"
                                                        data-validation-error-msg="Không được để trống"
                                                        data-validation="required">
                                                    @error('firstName')
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                            <div class="col-md-12">
                                                <fieldset class="form-group">
                                                    <label>Email<span class="required">*</span></label>
                                                    <input type="email" class="form-control form-control-lg"
                                                        name="email" id="email">
                                                    @error('email')
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                            <div class="col-md-12">
                                                <fieldset class="form-group">
                                                    <label>Mật khẩu<span class="required">*</span></label>
                                                    <input type="password" class="form-control form-control-lg"
                                                        name="password" id="password">
                                                    @error('password')
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </fieldset>
                                            </div>
                                            <div class="col-md-12">
                                                <fieldset class="form-group">
                                                    <label>Xác nhận mật khẩu<span class="required">*</span></label>
                                                    <input type="password" class="form-control form-control-lg"
                                                        name="password_confirmation" id="password_confirmation">
                                                    @error('password_confirmation')
                                                        <span style="color: red;">{{ $message }}</span>
                                                    @enderror
                                                </fieldset>
                                            </div>

                                            <div class="col-md-12">
                                                {!! NoCaptcha::display() !!}
                                            </div>
                                            <div class="col-md-12" style="margin-bottom: 10px">
                                                <button type="submit" class="btn btn-primary"
                                                    style="background-color: #007FF0; width: 120px">Đăng ký</button>
                                                <a href="{{ url('dang-nhap') }}" class="btn btn-style btn-dark"
                                                    style="width: 120px">Đăng
                                                    nhập</a>
                                            </div>

                                        </form>
                                        {!! NoCaptcha::renderJs() !!}
                                    </div>
                                    {{-- <div class="col-xs-12 text-center" style="margin-top:15px; padding: 0">
                                            <button type="submit" class="btn btn-primary">Đăng ký</button>
                                            <a href="{{ route('dang-nhap') }}" class="btn-link-style btn-register"
                                                style="margin-left: 20px;color:#007FF0;text-decoration: underline; ">Đăng
                                                nhập</a>
                                        </div> --}}
                                </div>
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('post-dang-ky') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '{{ route('dang-nhap') }}';
                        });
                    } else if (data.status === 'validation_error' || data.errors) {

                        let errors = '';
                        for (let field in data.errors) {
                            errors += `${data.errors[field].join('<br>')}<br>`;
                        }

                        Swal.fire({
                            icon: 'warning',
                            title: 'Lỗi xác thực',
                            html: errors,
                            confirmButtonText: 'OK'
                        });
                    } else {
                        console.log('Error response from server:', data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Đã xảy ra lỗi trong quá trình xử lý.',
                        confirmButtonText: 'OK'
                    });
                });
        })
    </script>
@endsection
