@extends('client.layouts.app')
@section('title')
    Liên hệ
@endsection
@section('style')
    <style>
        .popup-sapo {
            position: fixed;
            bottom: 80px;
            left: 17px;
            margin: 0;
            z-index: 30;
            top: auto !important
        }

        .popup-sapo .icon {
            position: relative;
            z-index: 4;
            height: 48px;
            width: 48px;
            text-align: center;
            border-radius: 50%;
            border: 1px solid #ffffff;
            cursor: pointer;
            background: #1ba0e2;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            animation: pulse 2s infinite;
            animation: pulse 2s infinite;
            cursor: pointer
        }

        .popup-sapo .icon svg {
            fill: #ffffff;
            width: 20px;
            height: 20px;
            transition: opacity 0.35s ease-in-out, -webkit-transform 0.35s ease-in-out;
            transition: opacity 0.35s ease-in-out, transform 0.35s ease-in-out;
            transition: opacity 0.35s ease-in-out, transform 0.35s ease-in-out, -webkit-transform 0.35s ease-in-out;
            animation: iconSkew 1s infinite ease-out;
            min-height: -webkit-fill-available
        }

        .popup-sapo .content {
            background: #1ba0e2;
            color: #fff;
            padding: 20px 10px 40px;
            border-radius: 10px;
            width: 300px;
            position: absolute;
            bottom: 27px;
            left: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            -webkit-transform-origin: 100% bottom;
            transform-origin: 0 bottom;
            transform: scale(0);
            -webkit-transform: scale(0);
            -moz-transform: scale(0);
            -ms-transform: scale(0);
            -o-transform: scale(0);
            transition: -webkit-transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), -webkit-transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            -webkit-transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1)
        }

        @media (max-width: 500px) {
            .popup-sapo .content {
                width: 250px
            }
        }

        .popup-sapo .content .title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 12px;
            margin-top: 8px;
            color: #fff;
        }

        .popup-sapo .content .close-popup-sapo {
            position: absolute;
            right: 10px;
            top: 5px;
            cursor: pointer
        }

        .popup-sapo .content .close-popup-sapo svg {
            width: 15px;
            height: 15px
        }

        .popup-sapo .content .close-popup-sapo svg path {
            fill: #fff
        }

        .popup-sapo .content ul {
            margin-bottom: 20px
        }

        .popup-sapo .content ul li {
            margin-bottom: 10px
        }

        .popup-sapo .content ul li svg {
            margin-right: 10px
        }

        .popup-sapo .content ul li svg path {
            fill: #fff
        }

        .popup-sapo .content ul li a {
            color: #fff
        }

        .popup-sapo .content ul li a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .popup-sapo .content .ghichu {
            font-style: italic;
            font-size: 14px
        }

        .popup-sapo.active .content {
            -ms-transition-delay: 0.1s;
            -webkit-transition-delay: 0.15s;
            transition-delay: 0.1s;
            transform: scale(1);
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1)
        }

        .wolf-chat-plugin {
            bottom: 30px;
            z-index: 99;
            background-color: rgb(10, 124, 255);
            align-items: center;
            border-radius: 60px;
            display: flex;
            height: 44px;
            padding: 0px 16px;
            position: fixed;
            width: fit-content;
            right: 0px;
            top: auto !important;
        }
    </style>
    <style>
        .box-maps {
            height: 350px;
        }

        footer.footer-other {
            margin-top: 0;
        }

        .search-more {
            margin-top: 0;
        }
    </style>

    <link rel="preload" as="script"
        href="client/cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js" />

    <link rel="preload" as="script"
        href="client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/api-jquery6d1d.js?1705894518705" />
@endsection

@section('content')
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="home" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="{{ route('home') }}" title="Trang chủ">
                                <span itemprop="name">Trang chủ</span>
                                <meta itemprop="position" content="1" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>

                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <strong itemprop="name">Liên hệ</strong>
                            <meta itemprop="position" content="2" />
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container contact">
        <div class="row">
            <div class="col-md-3 col-md-push-9">
                <div class="widget-item info-contact in-fo-page-content">
                    <div class="logos text-xs-left">
                        <a href="{{ route('home') }}" class="logo-wrapper ">
                            <img src="client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/logo-contact6d1d.png?1705894518705"
                                alt="logo Ant Du lịch" class="img-responsive" />
                        </a>
                    </div>
                    {{-- <p>Đặt tours du lịch!<br>Hơn 300 tours du lịch ở Việt Nam và Quốc tế</p> --}}
                    <!-- End .widget-title -->
                    <ul class="widget-menu contact-info-page">

                        <li><i class="fa fa-map-marker color-x" aria-hidden="true"></i>Đường Trịnh Văn Bô - Nam Từ Liêm - Hà
                            Nội</li>
                        <li><i class="fa fa-phone color-x" aria-hidden="true"></i> <a href="tel:19002424">1900 2424</a>
                        </li>
                        <li><i class="fa fa-envelope-o" aria-hidden="true"></i> <a
                                href="mailto:support@sapo.vn">support@garnet.vn</a></li>

                    </ul>
                    <!-- End .widget-menu -->
                </div>
            </div>
            <div class="col-md-9 col-md-pull-3">
                <div class="page-login">
                    <div id="login">
                        <h1 class="title-head">Liên hệ</h1>
                        <span class="margin-bottom-10 block">Bạn hãy điền nội dung tin nhắn vào form dưới đây và gửi cho
                            chúng tôi. Chúng tôi sẽ trả lời bạn sau khi nhận được.</span>

                        <script src="client/www.google.com/recaptcha/apif78f.js?render=6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK"></script>
                        <script>
                            grecaptcha.ready(function() {
                                grecaptcha.execute("6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK", {
                                    action: "contact"
                                }).then(function(token) {
                                    document.getElementById("Token-46b9c6299921430f8da811686dddcc55").value = token
                                });
                            });
                        </script>
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
                        <form action="{{ route('post.contact.index') }}" method="post" id="lien-he">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="user_id" value="{{ Auth()->user()->id ?? '' }}">
                            <div class="form-signup clearfix">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <fieldset class="form-group">
                                            <label>Họ tên<span class="required">*</span></label>
                                            <input type="text" name="name" id="name"
                                                class="form-control  form-control-lg"
                                                value="{{ Auth()->user()->name ?? '' }}" />
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <fieldset class="form-group">
                                            <label>Email<span class="required">*</span></label>
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                value="{{ Auth()->user()->email ?? '' }}" />
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <fieldset class="form-group">
                                            <label>Chủ đề<span class="required">*</span></label>
                                            <input type="text" name="subject" class="form-control form-control-lg" />
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <fieldset class="form-group">
                                            <label>Nội dung<span class="required">*</span></label>
                                            <textarea name="message" class="form-control form-control-lg" rows="5"></textarea>
                                        </fieldset>
                                        <div class="pull-xs-left" style="margin-top:20px;">
                                            <button type="submit" class="btn btn-blues btn-style btn-style-active">Gửi
                                                tin nhắn</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box-maps">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.3660844155734!2d106.65262831405934!3d10.78324826201816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec84dbc2ab5%3A0xe952d650e50b188f!2zMTc1IEzDvSBUaMaw4budbmcgS2nhu4d0LCBwaMaw4budbmcgNiwgVMOibiBCw6xuaCwgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1500909626466"
            width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
@endsection

@section('script')
    <script src="client/cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"
        type="text/javascript"></script>
    <script>
        $.validate({});
    </script>
    <script src="client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/api-jquery6d1d.js?1705894518705"
        type="text/javascript"></script>
    <script>
        $('.popup-sapo .icon').click(function() {
            $(".popup-sapo").toggleClass("active");
        });
        $('.close-popup-sapo').click(function() {
            $(".popup-sapo").toggleClass("active");
        });
    </script>
    <script src="client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/main6d1d.js?1705894518705"
        type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('lien-he').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('post.contact.index') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
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
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        })
                    } else if (data.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    } else if (data.errors) {

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
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Đã xảy ra lỗi trong quá trình xử lý.',
                        confirmButtonText: 'OK'
                    });
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
