@extends('client.layouts.app')
@section('title')
    Đăng Nhập
@endsection
@section('style')
    <style>
        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;

        }

        .align-items-center {
            align-items: center;

        }
    </style>
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
                            <strong itemprop="name">Đăng nhập tài khoản</strong>
                            <meta itemprop="position" content="2" />
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container margin-bottom-30">
        <h1 class="title-head"><span>Đăng nhập tài khoản</span></h1>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="page-login margin-bottom-30">
                    <div id="login">
                        <span>
                            Nếu bạn đã có tài khoản, đăng nhập tại đây.
                        </span>
                        <div class="social-login margin-bottom-10 margin-top-15">
                            <script>
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

                            <a href="{{ route('auth.google') }}" class="social-login--google"><img width="129px"
                                    height="37px" alt="google-login-button"
                                    src="http://bizweb.dktcdn.net/assets/admin/images/login/gp-btn.svg"></a>
                        </div>
                        <form method="post" id="loginForm" action="{{ route('post-dang-nhap') }}">
                            @csrf
                            <div class="form-signup">
                                {{-- @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif --}}
                            </div>
                            <div class="form-signup clearfix">
                                <fieldset class="form-group">
                                    <label>Email<span class="required">*</span></label>
                                    <input type="email" class="form-control form-control-lg" name="email"
                                        placeholder="Email" />
                                </fieldset>
                                <fieldset class="form-group">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <label>Mật khẩu<span class="required">*</span></label>
                                        <a href="{{ route('forgot-password') }}" class="text-muted">Quên mật khẩu?</a>
                                    </div>

                                    <input type="password" class="form-control form-control-lg" name="password"
                                        placeholder="Mật khẩu" />
                                </fieldset>
                                {!! NoCaptcha::display() !!}
                                <div class="pull-xs-left" style="margin-top: 15px;">
                                    <button class="btn btn-style btn-blues" type="submit" style="width: 120px">Đăng
                                        nhập</button>
                                    <a href="{{ url('dang-ky') }}" class="btn btn-style btn-dark" style="width: 120px">Đăng
                                        ký</a>
                                </div>
                            </div>
                        </form>
                        {!! NoCaptcha::renderJs() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function showRecoverPasswordForm() {
            document.getElementById('recover-password').style.display = 'block';
            document.getElementById('login').style.display = 'none';
        }

        function hideRecoverPasswordForm() {
            document.getElementById('recover-password').style.display = 'none';
            document.getElementById('login').style.display = 'block';
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const recaptchaResponse = document.querySelector('[name="g-recaptcha-response"]').value;

            // Kiểm tra nếu CAPTCHA không được xác minh
            if (!recaptchaResponse) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi CAPTCHA',
                    text: 'Vui lòng hoàn thành xác minh CAPTCHA!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '{{ route('dang-nhap') }}';
                });;
                return;
            }

            fetch('{{ route('post-dang-nhap') }}', {
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
                            window.location.href = '{{ route('home') }}';
                        });
                    } else if (data.status === 'validation_error') {
                        let errors = '';
                        for (let field in data.errors) {
                            errors += `${data.errors[field].join('<br>')}<br>`;
                        }

                        Swal.fire({
                            icon: 'warning',
                            title: 'Lỗi xác thực',
                            html: errors,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '{{ route('dang-nhap') }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại',
                            text: data.message,
                            confirmButtonText: 'Thử lại'
                        }).then(() => {
                            window.location.href = '{{ route('dang-nhap') }}';
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Có lỗi xảy ra, vui lòng thử lại sau.',
                        confirmButtonText: 'OK'
                    });
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
