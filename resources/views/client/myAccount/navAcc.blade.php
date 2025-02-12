@extends('client.layouts.app')

@section('content')
    <section class="signup page_customer_account">
        <style>
            .hidden {
                display: none;
            }

            .title-info.active {
                font-weight: bold;
                color: #f80000;
            }

            .title-info.active {
                background-color: #007bff;
                color: #fff;
                font-weight: bold;
                border-radius: 4px;
                padding: 5px 10px;
            }
        </style>

        <div class="container">
            <div class="row">
                <!-- Menu bên trái -->
                <div class="col-xs-12 col-sm-12 col-lg-2 col-left-ac alert ">
                    <div class="block-account">
                        <h5 class="title-account">Trang tài khoản</h5>
                        <p>Xin chào, <span style="color:#1ba0e2;">{{Auth::user()->name}}</span>&nbsp;!</p>
                        <ul>
                            <li>
                                <a class="title-info" href="{{route('my-account.index')}}" data-target="#account-info">Thông tin tài
                                    khoản</a>
                            </li>
                            <li>
                                <a class="title-info" href="{{route('user.indexOrderMy')}}" data-target="#orders">Đơn hàng của bạn</a>
                            </li>
                            <li>
                                <a class="title-info" href="{{route('user.indexChangePassword')}}" data-target="#change-password">Đổi mật
                                    khẩu</a>
                            </li>
                            {{-- <li>
                                <a class="title-info" href="{{route('user.indexAddress')}}" data-target="#addresses">Sổ địa chỉ</a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                @yield('navMy')
                
            </div>
        </div>
    </section>
@endsection
