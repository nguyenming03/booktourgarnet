<header class="header ">
    <div class="topbar hidden-sm hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class="top-info">
                        <li><i class="fa fa-phone color-x" aria-hidden="true"></i> <a href="tel:19002424">1900
                                2424</a></li>
                        <li><i class="fa fa-envelope-o" aria-hidden="true"></i> <a
                                href="mailto:support@garnet.vn">support@garnet.vn</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-inline f-right ul-account">
                        @if (Auth()->check() && count(Auth()->user()->notifications) > 0)
                            <li style="margin-right: 15px">
                                <a href="" id="showNotifications">
                                    <i class="fa fa-bell" aria-hidden="true"></i>
                                    <span class="badge badge-danger">
                                        {{ count(Auth()->user()->notifications) }}
                                    </span>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="" id="showNotifications">
                                    <i class="fa fa-bell" aria-hidden="true"></i>
                                    <span class="badge badge-danger" style="display: none;"></span>
                                </a>
                            </li>
                        @endif


                        @if (Auth::check())
                            <li>
                                <a href="{{ route('my-account.index') }}"><i class="fa fa-user" aria-hidden="true"></i>
                                    {{ Auth::user()->name }}</a>
                            </li>
                            <li>
                                <a href="{{ route('logouts') }}"
                                    style="border: none; background: none; padding: 0; color: inherit;">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('my-account.index') }}"><i class="fa fa-cart-plus"
                                        aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('dang-nhap') }}"><i class="fa fa-sign-in" aria-hidden="true"></i>
                                    Đăng nhập
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('dang-ky') }}"><i class="fa fa-user-plus" aria-hidden="true"></i>
                                    Đăng ký
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="header-main">
            <div class="row">
                <div class="col-md-3">
                    <button type="button" class="nav-line-group hidden-lg hidden-md">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="logo">

                        <a href="{{ url('/') }}" class="logo-wrapper ">
                            <img src="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/logo6d1d.png?1705894518705') }}"
                                alt="logo Ant Du lịch">
                        </a>
                    </div>
                    <a href="cart.html" class="icon-option-cart hidden-lg hidden-md hidden">
                        <span class="ng-binding ng-hide cart-products-count">0</span>
                    </a>
                </div>
                <div class="col-md-5">
                    <div class="search">
                        <div class="header_search search_form">
                            <form class="input-group search-bar search_form" action="{{ route('tour.search') }}"
                                method="get">
                                <input type="search" name="query" id="query"
                                    value="{{ !empty(Request::get('query')) ? Request::get('query') : '' }}"
                                    placeholder="Tìm kiếm tour..."
                                    class="input-group-field st-default-search-input search-text">
                                <span class="input-group-btn">
                                    <button class="btn icon-fallback-text">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 hidden-sm hidden-xs">
                    <div class="top-fun">
                        <div class="hotline">
                            <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/hotline.svg?1705894518705"
                                alt="Tổng đài miễn phí" />
                            <div class="hotline-text">

                                <a href="tel:19006750">1900 6750</a>

                                <span>Tổng đài miễn phí</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('client.partials.navbar')
</header>
