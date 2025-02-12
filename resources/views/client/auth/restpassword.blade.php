@extends('client.layouts.app')
@section('title')
   Đặt Lại Mật khẩu
@endsection
@section('style')
    <style>
        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
            /* Khoảng cách giữa các phần tử */
        }

        .align-items-center {
            align-items: center;
            /* Căn giữa theo chiều dọc */
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
                            <strong itemprop="name">Đặt lại mật khẩu</strong>
                            <meta itemprop="position" content="2" />
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container margin-bottom-30">
        <h1 class="title-head"><span>Đặt lại mật khẩu</span></h1>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="page-login margin-bottom-30">
                    <div id="login">

                        <form id="reset-password-form" method="post" action="">
                            @csrf
                            <div class="form-signup clearfix">
                                <fieldset class="form-group">
                                    <label>Mật khẩu<span class="required">*</span></label>
                                    <input type="password" class="form-control form-control-lg" name="password"
                                        id="password" placeholder="Nhập mật khẩu" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <label>Xác nhận mật khẩu<span class="required">*</span></label>
                                    <input type="password" class="form-control form-control-lg" name="cpassword"
                                        id="cpassword" placeholder="Xác nhận mật khẩu" />
                                </fieldset>
                                <div class="col-md-12">
                                    {!! NoCaptcha::display() !!}
                                </div>
                                <div class="pull-xs-left" style="margin-top: 15px;">
                                    <button class="btn btn-style btn-blues" type="submit" style="width: 150px">ĐỔI MẬT
                                        KHẨU</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('reset-password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            var password = document.getElementById('password').value;
            var cpassword = document.getElementById('cpassword').value;
    
            if (password !== cpassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Mật khẩu và xác nhận mật khẩu không khớp!',
                    confirmButtonText: 'OK'
                });
                return false;
            }
            if (password.length < 6) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Mật khẩu phải có ít nhất 6 ký tự!',
                    confirmButtonText: 'OK'
                });
                return false;
            }
    
            var captchaResponse = grecaptcha.getResponse();
            if (captchaResponse.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Vui lòng xác minh CAPTCHA!',
                    confirmButtonText: 'OK'
                });
                return false;
            }
          
            this.submit();
        });
    </script>
    
@endsection
