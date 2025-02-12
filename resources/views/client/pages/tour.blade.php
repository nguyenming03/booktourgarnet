@extends('client.layouts.app')
@section('title')
 Tour {{$category->category_tour}}
@endsection
@section('style')   
    <style>
        .rating {
            display: flex;
            /* Kích hoạt Flexbox */
            justify-content: flex-end;
            /* Căn tất cả sang bên phải */
            align-items: center;
            /* Căn giữa theo chiều dọc */
        }

        .rating .star-filled {
            color: gold;
            font-size: 1.5rem;
        }

        .rating .rating-number {
            font-size: 1rem;
            color: #555;
            margin-left: 5px;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">
                        <li class="home" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="{{ route('home') }}" title="Trang chủ">
                                <span itemprop="name">Trang chủ</span>
                                <meta itemprop="position" content="1">
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>

                        <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                            <strong itemprop="name">{{ $category->category_tour }}</strong>
                            <meta itemprop="position" content="2">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <section class="main_container collection col-md-12 tour-grid">
                <h1 class="title-head margin-top-0 text-center">{{ $category->category_tour }}</h1>
                <div class="category-products products">
                    @if ($category->tours->isEmpty())
                        <p>Hiện tại không có tour nào trong danh mục này.</p>
                    @else
                        <section class="products-view products-view-grid">
                            <div class="row">
                                @foreach ($category->tours as $tour)
                                    <div class="col-100 col-xs-6 col-sm-4 col-md-3 col-lg-3">
                                        <div class="product-box">
                                            <div class="product-thumbnail">
                                                <a href="{{ route('detail', $tour->id) }}" title="{{ $tour->title }}">
                                                    <img src="{{ Storage::url($tour->image) }}" alt="{{ $tour->title }}">
                                                </a>
                                            </div>
                                            <div class="product-info a-left">
                                                <h3 class="product-name">
                                                    <a href="{{ route('detail', $tour->id) }}" title="{{ $tour->title }}">
                                                        {{ $tour->name }}
                                                        [{{ $tour->journeys }}]
                                                    </a>
                                                </h3>
                                                <div class="clearfix">
                                                    <div class="box-prices">
                                                        <div class="price-box clearfix">
                                                            <div class="special-price f-left">
                                                                <span class="price product-price">
                                                                    {{ number_format($tour->price_old * (1 - $tour->sale / 100), 0, '', '.') }}
                                                                    VNĐ
                                                                </span>
                                                            </div>
                                                            <div class="old-price">
                                                                <span class="price product-price-old">
                                                                    {{ number_format($tour->price_old, 0, '', '.') }} VNĐ
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-tag">
                                                        <ul class="ct_course_list">
                                                            <li>
                                                                <div class="rating">
                                                                    <span class="star-filled">&#9733;</span>
                                                                    <span
                                                                        class="rating-number">{{ round($tour->average_rating, 1) }}
                                                                        ({{ $tour->rating_count }})
                                                                    </span>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-heart add-to-favorite"
                                                                    data-id="{{ $tour->id }}"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="box-date-tour">
                                                    <ul class="ct_course_list">
                                                        <li class="clearfix">
                                                            <div class="ulimg"><img
                                                                    src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg"
                                                                    alt="Khởi hành" /></div>
                                                            Khởi hành:
                                                            {{ \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') }}
                                                            tới
                                                            {{ \Carbon\Carbon::parse($tour->end_date)->format('d/m/Y') }}
                                                        </li>
                                                        <li class="clearfix">
                                                            <div class="ulimg"><img
                                                                    src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg"
                                                                    alt="Thời gian" /></div>
                                                            Thời gian: {{ $tour->schedule }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
