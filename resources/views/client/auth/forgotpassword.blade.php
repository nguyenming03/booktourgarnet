@extends('client.layouts.app')
@section('title')
    Quên Mật khẩu
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
                            <strong itemprop="name">Bạn quên mật khẩu?</strong>
                            <meta itemprop="position" content="2" />
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container margin-bottom-30">
        <h1 class="title-head"><span>Bạn quên mật khẩu?</span></h1>
        <div class="row">

            <div class="col-md-6 col-sm-6">
                <div id="recover-password" class="form-signup">
                    <span>
                        Nhập địa chỉ email để lấy lại mật khẩu qua email.
                    </span>
                    <form method="post" id="forgot-password-form" action="{{ route('post-forgot-password') }}">
                        @csrf
                        @method('POST')
                        <div class="form-signup aaaaaaaa">

                        </div>

                        <div class="form-signup clearfix">
                            <fieldset class="form-group">
                                <label>Email<span class="required">*</span></label>
                                <input type="email" class="form-control form-control-lg" value="" name="email"
                                    id="recover-email" placeholder="Email" data-validation="email"
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$"
                                    data-validation-error-msg="Email sai định dạng" />
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            {!! NoCaptcha::display() !!}
                        </div>
                        <div class="action_bottom">
                            <button class="btn btn-style btn-blues" style="margin-top: 15px;" type="submit">Gửi liên kết
                                đặt lại mật khẩu</button>
                            <a href="{{ route('dang-nhap') }}" class="btn btn-style btn-dark" style="margin-top: 15px;"
                                type="submit">QUAY LẠI ĐĂNG NHẬP</a>
                        </div>
                    </form>
                    {!! NoCaptcha::renderJs() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}

    <script>
        $('#forgot-password-form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: response.message ||
                            'Vui lòng kiểm tra email và đặt lại mật khẩu của bạn!',
                    });
                    form[0].reset();
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: xhr.responseJSON.message || 'Có lỗi xảy ra, vui lòng thử lại!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                       
                        location.reload();
                    });
                }
            });
        });
    </script>
@endsection
