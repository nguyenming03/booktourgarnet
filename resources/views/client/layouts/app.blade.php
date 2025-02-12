<!DOCTYPE html>
<html lang="vi">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>
        @yield('title') | Garnet Du Lịch
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="keywords" content="Liên hệ, Ant Du lịch, ant-du-lich.mysapo.net" />
    <link rel="canonical" href="lien-he.html" />
    <link rel="dns-prefetch" href="index.html">
    <link rel="dns-prefetch" href="http://bizweb.dktcdn.net/">
    <link rel="dns-prefetch" href="http://www.google-analytics.com/">
    <link rel="dns-prefetch" href="http://www.googletagmanager.com/">


    <link rel="icon"
        href="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/favicon6d1d.png?1705894518705') }}"
        type="image/x-icon" />


    <link rel="preload" as="style" type="text/css"
        href="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/bootstrap.scss6d1d.css') }}"
        onload="this.rel='stylesheet'" />
    <link href="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/bootstrap.scss6d1d.css') }}"
        rel="stylesheet" type="text/css" media="all" />
    <link rel="preload" as="style" type="text/css"
        href="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/base.scss6d1d.css') }}"
        onload="this.rel='stylesheet'" />
    <link href="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/base.scss6d1d.css') }}"
        rel="stylesheet" type="text/css" media="all" />

    <link rel="preload" as="style" type="text/css"
        href="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/ant-du-lich.scss6d1d.css') }}"
        onload="this.rel='stylesheet'" />
    <link href="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/ant-du-lich.scss6d1d.css') }}"
        rel="stylesheet" type="text/css" media="all" />

    <link rel="preload" as="script"
        href="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/jquery-2.2.3.min6d1d.js') }}" />
    <script src="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/jquery-2.2.3.min6d1d.js') }}"
        type="text/javascript"></script>
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
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f4f4f4;
            color: #6cacf1;
        }
    </style>
    <script>
        var Bizweb = Bizweb || {};
        Bizweb.store = 'ant-du-lich.mysapo.net';
        Bizweb.id = 299077;
        Bizweb.theme = {
            "id": 642224,
            "name": "Ant Du lịch",
            "role": "main"
        };
        Bizweb.template = 'page.contact';
        if (!Bizweb.fbEventId) Bizweb.fbEventId = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0,
                v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    </script>
    <script>
        (function() {
            function asyncLoad() {
                var urls = [
                    "https://google-shopping.sapoapps.vn/conversion-tracker/global-tag/3163.js?store=ant-du-lich.mysapo.net",
                    "https://google-shopping.sapoapps.vn/conversion-tracker/event-tag/3163.js?store=ant-du-lich.mysapo.net"
                ];
                for (var i = 0; i < urls.length; i++) {
                    var s = document.createElement('script');
                    s.type = 'text/javascript';
                    s.async = true;
                    s.src = urls[i];
                    var x = document.getElementsByTagName('script')[0];
                    x.parentNode.insertBefore(s, x);
                }
            };
            window.attachEvent ? window.attachEvent('onload', asyncLoad) : window.addEventListener('load', asyncLoad,
                false);
        })();
    </script>

    <script>
        window.BizwebAnalytics = window.BizwebAnalytics || {};
        window.BizwebAnalytics.meta = window.BizwebAnalytics.meta || {};
        window.BizwebAnalytics.meta.currency = 'đ';
        window.BizwebAnalytics.tracking_url = 's.html';

        var meta = {};


        for (var attr in meta) {
            window.BizwebAnalytics.meta[attr] = meta[attr];
        }
    </script>
    @yield('style')
    <script src="{{ url('client/ant-du-lich.mysapo.net/dist/js/stats.minbadf.js?v=96f2ff2') }}"></script>
    <style>
        .notification-popup {
            position: fixed;
            top: 10px;
            right: 20px;
            z-index: 1000;
        }


        .notification-popup {
            display: none;
            position: absolute;
            top: 310px;
            right: 20px;
            width: 350px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: fadeIn 0.3s ease-in-out;
        }

        .notification-header h4 {
            color: #fff
        }

        .notification-header {
            background: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .notification-body {
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
        }

        .notification-time {
            color: #aaa;
            font-size: 12px;
        }

        .notification-icon img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .notification-content .title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .notification-footer {
            padding: 10px;
            background: #f1f1f1;
            text-align: center;
        }



        /* Hiệu ứng hiển thị */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }



        .back-to-top {
            position: fixed;
            bottom: 10px !important;
            right: 20px;
            background-color: #007bff;
            color: white;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .back-to-top:hover {
            background-color: #0056b3;
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .navbar-nav .badge-danger {
            margin-top: -10px;
            background-color: #dc3545;
            color: white;
            font-size: 1rem;
        }

        .badge-danger {
            position: absolute;
            background-color: #dc3545;
            color: white;
            font-size: 1rem;
            padding: 1px 3px;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <?php
    use App\Models\Admins\Category;
    $categoryes = Category::whereNull('parent_id')->with('children')->get();
    ?>
    @include('client.partials.header')

    @yield('content')

    @include('client.partials.footer')

    <div id="popup-cart" class="modal fade" role="dialog">
        <div id="popup-cart-desktop" class="clearfix">
            <div class="title-popup-cart">
                <i class="fa fa-check" aria-hidden="true"></i> Bạn đã thêm <span class="cart-popup-name"></span>
                vào giỏ
                hàng
            </div>
            <div class="title-quantity-popup">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Giỏ hàng của bạn (<span
                    class="cart-popup-count"></span> sản phẩm) <i class="fa fa-caret-right" aria-hidden="true"></i>
            </div>
            <div class="content-popup-cart">
                <div class="thead-popup">
                    <div style="width: 55%;" class="text-left">Sản phẩm</div>
                    <div style="width: 15%;" class="text-right">Đơn giá</div>
                    <div style="width: 15%;" class="text-center">Số lượng</div>
                    <div style="width: 15%;" class="text-right">Thành tiền</div>
                </div>
                <div class="tbody-popup">
                </div>
                <div class="tfoot-popup">
                    <div class="tfoot-popup-1 clearfix">
                        <div class="pull-left popup-ship">

                            <p>Giao hàng trên toàn quốc</p>
                        </div>
                        <div class="pull-right popup-total">
                            <p>Thành tiền: <span class="total-price"></span></p>
                        </div>
                    </div>
                    <div class="tfoot-popup-2 clearfix">
                        <a class="button btn-proceed-checkout" title="Tiến hành đặt hàng" href="cart.html"><span>Tiến
                                hành đặt hàng <i class="fa fa-long-arrow-right" aria-hidden="true"></i></span></a>
                        <a class="button btn-continue" title="Tiếp tục mua hàng"
                            onclick="$('#popup-cart').modal('hide');"><span><span><i class="fa fa-caret-left"
                                        aria-hidden="true"></i> Tiếp tục mua hàng</span></span></a>
                    </div>
                </div>
            </div>
            <a title="Close" class="quickview-close close-window" href="javascript:;"
                onclick="$('#popup-cart').modal('hide');"><i class="fa  fa-close"></i></a>
        </div>

    </div>
    <div id="myModal" class="modal fade" role="dialog">
    </div>
    <link rel="preload" as="script"
        href="client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/main6d1d.js" />
    <script src="client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/main6d1d.js" type="text/javascript"></script>

    <div class="backdrop__body-backdrop___1rvky"></div>
    <div class="c-menu--slide-left">
        <div class="la-nav-top-login">
            <div class="la-avatar-nav p-relative text-center">
                <a href="account/logina3b1.html">
                    <img class="img-responsive"
                        src="client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/av-none-user6d1d.png"
                        alt="avatar">
                </a>
                <div class="la-hello-user-nav ng-scope">Xin chào</div>
                <img id="close-nav" class="c-menu__close"
                    src="client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/ic-close-menu6d1d.png"
                    alt="close nav">
            </div>
            <div class="la-action-link-nav text-center">

                <a href="account/login.html" class="uppercase">ĐĂNG NHẬP</a>
                <a href="account/register.html" class="uppercase">ĐĂNG KÝ</a>

            </div>
        </div>
        <div class="la-scroll-fix-infor-user">
            <!--CATEGORY-->
            <div class="la-nav-menu-items">
                <div class="la-title-nav-items">Tất cả danh mục</div>
                <ul class="la-nav-list-items">


                    <li class="ng-scope">
                        <a href="index.html">Trang chủ</a>
                    </li>

                    <li class="ng-scope">
                        <a href="gioi-thieu.html">Giới thiệu</a>
                    </li>

                    <li class="ng-scope ng-has-child1">
                        <a href="tour-trong-nuoc.html">Tour trong nước <i class="fa fa-plus fa1"
                                aria-hidden="true"></i></a>
                        <ul class="ul-has-child1">


                            <li class="ng-scope ng-has-child2">
                                <a href="mien-trung.html">Miền Trung <i class="fa fa-plus fa2"
                                        aria-hidden="true"></i></a>
                                <ul class="ul-has-child2">

                                    <li class="ng-scope">
                                        <a href="du-lich-quang-binh.html">Du lịch Quảng Bình</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-hue.html">Du lịch Huế</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-da-nang.html">Du lịch Đà Nẵng</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-hoi-an.html">Du lịch Hội An</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-nha-trang.html">Du lịch Nha Trang</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-phan-thiet.html">Du lịch Phan Thiết</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-da-lat.html">Du lịch Đà Lạt</a>
                                    </li>

                                </ul>
                            </li>

                            <li class="ng-scope ng-has-child2">
                                <a href="mien-bac.html">Miền Bắc <i class="fa fa-plus fa2"
                                        aria-hidden="true"></i></a>
                                <ul class="ul-has-child2">

                                    <li class="ng-scope">
                                        <a href="du-lich-ha-noi.html">Du lịch Hà Nội</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-ha-long.html">Du lịch Hạ Long</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-sapa.html">Du lịch Sapa</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-ninh-binh.html">Du lịch Ninh Bình</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-hai-phong.html">Du lịch Hải Phòng</a>
                                    </li>

                                </ul>
                            </li>

                            <li class="ng-scope ng-has-child2">
                                <a href="mien-nam.html">Miền Nam <i class="fa fa-plus fa2"
                                        aria-hidden="true"></i></a>
                                <ul class="ul-has-child2">

                                    <li class="ng-scope">
                                        <a href="du-lich-phu-quoc.html">Du lịch Phú Quốc</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-con-dao.html">Du lịch Côn Đảo</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-can-tho.html">Du lịch Cần Thơ</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-vung-tau.html">Du lịch Vũng Tàu</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-ben-tre.html">Du lịch Bến Tre</a>
                                    </li>

                                    <li class="ng-scope">
                                        <a href="du-lich-dao-nam-du.html">Du lịch Đảo Nam Du</a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="ng-scope ng-has-child1">
                        <a href="tour-nuoc-ngoai.html">Tour nước ngoài <i class="fa fa-plus fa1"
                                aria-hidden="true"></i></a>
                        <ul class="ul-has-child1">

                            <li class="ng-scope">
                                <a href="du-lich-chau-a.html">Du lịch Châu Á</a>
                            </li>

                            <li class="ng-scope">
                                <a href="du-lich-chau-au.html">Du lịch Châu Âu</a>
                            </li>

                            <li class="ng-scope">
                                <a href="du-lich-chau-uc.html">Du lịch Châu Úc</a>
                            </li>

                            <li class="ng-scope">
                                <a href="du-lich-chau-my.html">Du lịch Châu Mỹ</a>
                            </li>

                        </ul>
                    </li>

                    <li class="ng-scope">
                        <a href="{{ route('service.index') }}">Dịch vụ tour</a>
                    </li>

                    {{-- <li class="ng-scope">
                        <a href="{{ route('handbook.index') }}">Cẩm nang du lịch</a>
                    </li> --}}

                    <li class="ng-scope">
                        <a href="{{ route('contact.index') }}">Liên hệ</a>
                    </li>

                </ul>
            </div>
            <div class="la-nav-slide-banner">

                <a href="#">
                    <img alt="Ant Du lịch"
                        src="client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/left-menu-banner-16d1d.png" />
                </a>

            </div>
        </div>
    </div>

    <ul class="the-article-tools">

        <li class="btnZalo zalo-share-button">
            <a target="_blank" href="http://zalo.me/0982 362 509" title="Chat qua Zalo">
                <span class="ti-zalo"></span>
            </a>
            <span class="label">Chat qua Zalo</span>
        </li>

        <li class="btnFacebook">
            <a target="_blank" href="https://www.messenger.com/t/vemiendisan" title="Chat qua Messenger">
                <span class="ti-facebook"></span>
            </a>
            <span class="label">Chat qua Messenger</span>
        </li>

        <li class="btnphone">
            <button type="button" data-toggle="modal" data-target="#hotlineModal">
                <span class="fa fa-phone"></span>
            </button>
            <span class="label">Hotline đặt Tour</span>
        </li>

    </ul>
    <div class="modal fade" id="hotlineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Hotline đặt Tour</h4>
                </div>
                <div class="modal-body">
                    <div class="on-content">Chúng tôi cam kết luôn nỗ lực đem đến những giá trị dịch vụ tốt nhất cho
                        khách hàng và đối tác để tiếp tục khẳng định vị trí hàng đầu của thương hiệu Ant Du lịch.</div>
                    <div class="on-sup-info">

                        <ul>
                            <li><strong>Ant Du lịch Hồ Chí Minh</strong></li>
                            <li>
                                <i class="fa fa-map-marker" aria-hidden="true"></i> 175 Lý Thường Kiệt, Phường 6,
                                Quận
                                Tân Bình, TP. Hồ Chí Minh.
                            </li>
                            <li>
                                <i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:0123456789">0123 456
                                    789</a>
                            </li>
                            <li>
                                <i class="fa fa-envelope" aria-hidden="true"></i> <a
                                    href="mailto:antdulich@ant.com.vn">antdulich@ant.com.vn</a>
                            </li>
                        </ul>

                        <ul>
                            <li><strong>Ant Du lịch Huế</strong></li>
                            <li>
                                <i class="fa fa-map-marker" aria-hidden="true"></i> 175 Lý Thường Kiệt, Quận Phú
                                Nhận,
                                TP. Huế.
                            </li>
                            <li>
                                <i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:0123456789">0123 456
                                    789</a>
                            </li>
                            <li>
                                <i class="fa fa-envelope" aria-hidden="true"></i> <a
                                    href="mailto:antdulich@ant.com.vn">antdulich@ant.com.vn</a>
                            </li>
                        </ul>

                        <ul>
                            <li><strong>Ant Du lịch Đà Nẵng</strong></li>
                            <li>
                                <i class="fa fa-map-marker" aria-hidden="true"></i> 20 Lý Thường Kiệt, Quận Hải
                                Châu,
                                TP. Đà Nẵng.
                            </li>
                            <li>
                                <i class="fa fa-phone" aria-hidden="true"></i> <a href="tel:0123456789">0123 456
                                    789</a>
                            </li>
                            <li>
                                <i class="fa fa-envelope" aria-hidden="true"></i> <a
                                    href="mailto:antdulich@ant.com.vn">antdulich@ant.com.vn</a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.popup-sapo .icon').click(function() {
            $(".popup-sapo").toggleClass("active");
        });
        $('.close-popup-sapo').click(function() {
            $(".popup-sapo").toggleClass("active");
        });
    </script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        $(document).ready(function() {
            // Khi nhấp vào tab
            $(".tab-link").click(function() {
                var tab = $(this).data('tab'); // Lấy giá trị data-tab

                // Ẩn tất cả tab-content và hiển thị tab tương ứng
                $(".tab-content").hide();
                $("." + tab).show();

                // Xóa active khỏi tất cả các tab-link và thêm vào tab hiện tại
                $(".tab-link").removeClass("active");
                $(this).addClass("active");
            });

            // Cài đặt owl-carousel
            $(".owl-carousel").owlCarousel({
                items: 3,
                margin: 20,
                nav: true,
                dots: true,
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- <script>
        let actionCount = 0;
        let lastActionTime = Date.now(); // Lưu thời gian của lần hành động cuối cùng
        const spamThreshold = 10; // Số lần hành động cho phép
        const timeWindow = 3000; // Thời gian cửa sổ tính spam (ms), ví dụ 3 giây

        // Lắng nghe mọi sự kiện click và submit trên trang
        $('body').on('click submit', handleUserAction);

        function handleUserAction(e) {
            const currentTime = Date.now();
           
            if (currentTime - lastActionTime < timeWindow) {
                actionCount++;
            } else {
                actionCount = 1; // Nếu hành động đã thực hiện sau một khoảng thời gian dài, reset lại
            }

            lastActionTime = currentTime;

            if (actionCount > spamThreshold) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cảnh báo',
                    text: 'Vui lòng thao tác chậm lại, bạn đang thao tác quá nhanh!',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });

                actionCount = 0;
            }
        }
    </script> --}}


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    </script>
    @yield('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- add favorite --}}
    <script>
        $(document).on('click', '.add-to-favorite', function() {
            let tourId = $(this).data('id');

            $.ajax({
                url: "{{ route('favorite.add') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    tour_id: tourId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại!',
                            text: response.message,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Đã có lỗi xảy ra, vui lòng thử lại.',
                    });
                }
            });
        });
    </script>

    {{-- popup thông báo --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationIcon = document.getElementById('showNotifications');
            const notificationPopup = document.getElementById('notificationPopup');



            // Hiển thị popup khi click
            notificationIcon.addEventListener('click', function(e) {
                e.preventDefault();
                notificationPopup.style.display =
                    notificationPopup.style.display === 'block' ? 'none' : 'block';
            });

            // Ẩn popup khi click ra ngoài
            window.addEventListener('click', function(e) {
                if (!notificationIcon.contains(e.target) && !notificationPopup.contains(e.target)) {
                    notificationPopup.style.display = 'none';
                }
            });
        });
    </script>
    {{-- đọc thông báo --}}
    <script>
        document.getElementById('markAllRead').addEventListener('click', function() {
            fetch("{{ route('notifications.markAllRead') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: data.message,
                        });
                        // Gửi AJAX để lấy số lượng thông báo chưa đọc
                        $.ajax({
                            url: "{{ route('notifications.unreadCount') }}",
                            type: "GET",
                            success: function(response) {
                                if (response.success) {
                                    // Cập nhật số lượng trong badge
                                    $('.badge-danger').text(response.unreadCount);
                                }
                            },
                            error: function() {
                                console.error('Lỗi khi lấy số lượng thông báo chưa đọc.');
                            }
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại!',
                            text: data.message,
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <script>
        const backToTop = document.querySelector('.back-to-top');


        window.addEventListener('scroll', () => {
            if (window.scrollY > 200) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });


        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    <script>
        function resquet() {
            fetch('', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: error.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '{{ route('home') }}';
                            });;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        setInterval(resquet, 5000);
    </script>

</body>

</html>
