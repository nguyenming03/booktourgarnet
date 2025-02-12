@extends('client.layouts.app')
@section('title')
   Tất Cả Tour  
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

        .select-style .form-control {
            border-radius: 0;
            border: 1px solid #ccc;
            padding: 5px;
            font-size: 14px;
            height: auto;
            box-shadow: none;
        }

        .select-style .form-control:hover {
            border-color: #007bff;
        }

        .select-style aside.aside-item {
            margin-bottom: 15px;
        }

        .select-style aside.aside-item select {
            width: 100%;
            display: block;
            background-color: #fff
        }

        .select-style .form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: #fff url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16"%3E%3Cpath fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/%3E%3C/svg%3E') no-repeat right 10px center;
            background-size: 16px 16px;
            padding-right: 30px;
        }

        .select-style .form-control:hover {
            border-color: #007bff;
        }


        @media (max-width: 768px) {
            .select-style .form-control {
                font-size: 12px;
                padding-right: 25px;
            }
        }

        @media (max-width: 768px) {
            .select-style .form-control {
                font-size: 12px;
            }
        }

        .star {
            color: #ffc107 !important;
            font-size: 14px !important;
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
                            <strong itemprop="name">Tất cả các tour</strong>
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
                <h1 class="title-head margin-top-0 text-center">Tất cả các tour</h1>
                <div class="sortPagiBar tour-sortby row-filter d-flex ">
                    <div class="clearfix row select-style">
                        <div class="col-md-4 col-sm-6">
                            <aside class="aside-item ">
                                <select id="filter-price" class="form-control">
                                    <option value="" selected>Chọn khoảng giá</option>
                                    <option value="0,2000000">Dưới 2.000.000đ</option>
                                    <option value="2000000,4000000">2.000.000đ - 4.000.000đ</option>
                                    <option value="4000000,6000000">4.000.000đ - 6.000.000đ</option>
                                    <option value="6000000,8000000">6.000.000đ - 8.000.000đ</option>
                                    <option value="8000000,10000000">8.000.000đ - 10.000.000đ</option>
                                    <option value="10000000,9999999999">Trên 10.000.000đ</option>
                                </select>
                            </aside>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <aside class="aside-item ">
                                <select id="filter-location" class="form-control">
                                    <option value="" selected>Chọn điểm du lịch</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </aside>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <aside class="aside-item ">
                                <select id="filter-rating" class="form-control">
                                    <option value="" selected style="color: #000000">Chọn đánh giá</option>
                                    @foreach ($ratings as $rating)
                                        <option value="{{ $rating->id }}" style="color: #ffc107">
                                            @for ($i = 1; $i <= $rating->star; $i++)
                                                <span class="star">&#9733;</span>
                                            @endfor
                                        </option>
                                    @endforeach
                                </select>
                            </aside>
                        </div>

                    </div>
                </div>
                <div class="category-products products">
                    <section class="products-view products-view-grid">
                        <div id="tours-container" class="row">
                            @foreach ($getTour as $tour)
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
                </div>
            </section>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#filter-price, #filter-location, #filter-rating').on('change', function() {
                let price = $('#filter-price').val();
                let location = $('#filter-location').val();
                let rating = $('#filter-rating').val();


                // console.log("Price:", price, "Location:", location, "Rating:", rating);

                let priceRange = price ? price.split(',') : [null, null];
                $.ajax({
                    url: '{{ route('tour.filter') }}',
                    method: 'GET',
                    data: {
                        min_price: priceRange[0],
                        max_price: priceRange[1],
                        location: location,
                        rating: rating
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            $('#tours-container').html(response.html);
                        } else {
                            $('#tours-container').html(
                                '<p style="text-align: center; font-size: 20px; font-weight: bold;">Không có tour nào phù hợp.</p>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Có lỗi xảy ra khi tải dữ liệu:", xhr, status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Đã có lỗi xảy ra',
                            text: 'Vui lòng thử lại sau.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endsection
