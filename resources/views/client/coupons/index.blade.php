@extends('client.layouts.app')

@section('title')
    Mã giảm giá
@endsection

@section('style')
    <style>
        .coupon {
            background: #ebebeb;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;

        }

        .coupon-code {
            font-size: 18px;
            font-weight: bold;
            color: #16d164;
        }

        .btn-coupons {
            background-color: #ffffff;
            color: #029c54;
            border: 1px solid #029c54;
            border-radius: 8px;
            /* padding: 10px 20px; */
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 55px;
        }

        .btn-coupons:hover {
            background-color: #029c54;
            color: white;
            transform: scale(1.05);
        }

        .btn-coupons:focus {
            outline: none;
        }

        .badge {
            background-color: #46A609;
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
                            <strong itemprop="name">Mã Giảm Giá</strong>
                            <meta itemprop="position" content="2">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row">
                @foreach ($coupons as $coupon)
                    <div class="col-sm-6">
                        <div class="coupon bg-white rounded mb-3 d-flex justify-content-between">
                            <div class="kiri p-3">
                                <div class="icon-container">
                                    <div class="icon-container_box">
                                        <img src="https://magiamgia.com/wp-content/uploads/2020/12/fnal-logo.png"
                                            width="85" alt="totoprayogo.com" class="" />
                                    </div>
                                </div>
                            </div>
                            <div class="tengah py-3 d-flex w-100 justify-content-start">
                                <div>
                                    <span class="badge badge-success">{{ $coupon->name }}</span>
                                    <h3 class="lead" id="text-to-copy-{{ $coupon->id }}">{{ $coupon->code }}</h3>
                                    <p>{{ $coupon->tour->name }}</p>
                                </div>
                            </div>
                            <div class="kanan">
                                <div class="info m-3 d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="block">
                                            <span class="time font-weight-light">
                                                <span>Còn {{ $coupon->days_remaining }} ngày</span>
                                            </span>
                                        </div>
                                        <button class="btn btn-coupons" onclick="copyText({{ $coupon->id }})">Copy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function copyText(couponId) {

            var copyText = document.getElementById("text-to-copy-" + couponId).innerText;


            var textArea = document.createElement("textarea");
            textArea.value = copyText;
            document.body.appendChild(textArea);


            textArea.select();
            textArea.setSelectionRange(0, 99999);


            document.execCommand("copy");


            document.body.removeChild(textArea);


            Swal.fire({
                icon: 'success',
                title: 'Đã sao chép mã giảm giá😊',
                showConfirmButton: false,
                timer: 1200,
                timerProgressBar: true,

            });
        }
    </script>
@endsection
