@extends('client.layouts.app')

@section('title')
    Giới Thiệu
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        .image-container {
            width: 45%;
            text-align: center;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease-out forwards;
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
            animation: moveImage 5s infinite alternate;
        }

        .image-container.visible {
            opacity: 1;
            transform: translateY(0);

        }

        @keyframes moveImage {
            0% {
                transform: translateX(0);

            }

            50% {
                transform: translateX(10px);

            }

            100% {
                transform: translateX(0);

            }
        }

        .caption {
            font-size: 1.1rem;
            color: #7f8c8d;
            margin-top: 1rem;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .intro-image {
            width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
            animation: fadeIn 1s ease-out;
        }

        .intro-text {
            width: 45%;

            font-size: 1.2rem;
            color: #34495e;
            line-height: 1.8;
            margin-bottom: 2rem;
            text-align: justify;
            animation: fadeIn 1s ease-out;
        }

        .highlight {
            font-weight: bold;
            color: #e74c3c;
        }

        .content-block {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4rem;
        }

        .image-container {
            margin-top: 2rem;
            text-align: center;
        }

        .caption {
            font-size: 1.1rem;
            color: #7f8c8d;
            margin-top: 1rem;
        }

        .breadcrumb-container {
            margin-bottom: 20px;
        }

        /* Animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hover effect for text */
        .intro-text a {
            color: #2980b9;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .intro-text a:hover {
            color: #e74c3c;
        }
    </style>
@endsection

@section('content')
    <section class="breadcrumb-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">
                        <li class="home" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="index.html" title="Trang chủ">
                                <span itemprop="name">Trang chủ</span>
                                <meta itemprop="position" content="1">
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>
                        <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem">
                            <strong itemprop="name">Giới thiệu</strong>
                            <meta itemprop="position" content="2">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <h1 class="section-title">Chào Mừng Đến Với Garnet - Nơi Mỗi Chuyến Đi Là Một Kỷ Niệm</h1>
    <div class="container">
        <div class="row">
            <section class="col-md-12">
                <section class="content-block">

                    <div class="intro-text">
                        <p>
                            <b>Garnet</b> là nền tảng du lịch trực tuyến được tạo ra để mang đến cho bạn những chuyến đi an
                            toàn, thú vị và đầy ý nghĩa. Với hơn 1000+ tour du lịch trong và ngoài nước, chúng tôi giúp bạn
                            dễ
                            dàng tìm kiếm và đặt những chuyến đi tuyệt vời nhất, từ những điểm đến huyền bí, kỳ vĩ đến những
                            thành phố năng động, sôi động.
                        </p>
                        <hr>
                        <p>
                            <span class="highlight">Tại Garnet</span>, chúng tôi không chỉ cung cấp các tour du lịch, mà còn
                            mang đến cho bạn một trải nghiệm trọn vẹn, từ lúc lên kế hoạch cho đến khi bạn kết thúc chuyến
                            đi.
                            Dịch vụ của chúng tôi cam kết sự tiện lợi, an toàn và sự hài lòng tối đa cho khách hàng. Đặc
                            biệt,
                            chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7 trong suốt hành trình.
                        </p>
                        <hr>
                        <p>
                            Với mỗi chuyến đi cùng <b>Garnet</b>, bạn không chỉ đơn thuần là tham quan những địa điểm nổi
                            tiếng,
                            mà còn được đắm chìm trong những câu chuyện văn hóa đặc sắc, thưởng thức ẩm thực tuyệt vời, và
                            trải
                            nghiệm những hoạt động ngoài trời đầy thú vị. Hãy bắt đầu hành trình của bạn ngay hôm nay!
                        </p>
                        <hr>
                        <p>
                            Chúng tôi tự hào là lựa chọn hàng đầu cho những ai yêu thích du lịch, và cam kết mang đến cho
                            bạn
                            những chuyến đi không thể nào quên. <a href="http://127.0.0.1:8000/lien-he">Liên hệ với chúng
                                tôi</a> để được tư vấn thêm
                            về các tour du lịch độc đáo và hấp dẫn.
                        </p>
                    </div>
                    <div class="image-container">
                        <img src="https://imadtravel.com/wp-content/uploads/2023/05/Benefits-of-Booking-with-a-Travel-Agent_IMAD-Travel.webp"
                            alt="Tour Du Lịch" class="intro-image">
                        <p class="caption">Khám phá những điểm đến đẹp mê hồn cùng Garnet</p>
                    </div>


                </section>
            </section>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        // Kiểm tra nếu phần tử đã xuất hiện trong viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        // Thêm sự kiện cuộn trang để kiểm tra khi nào ảnh xuất hiện
        window.addEventListener('scroll', function() {
            const images = document.querySelectorAll('.image-container');
            images.forEach(function(image) {
                if (isInViewport(image)) {
                    image.classList.add('visible'); // Thêm class "visible" để hiển thị ảnh
                }
            });
        });

        // Kiểm tra ngay khi trang tải
        window.addEventListener('load', function() {
            const images = document.querySelectorAll('.image-container');
            images.forEach(function(image) {
                if (isInViewport(image)) {
                    image.classList.add('visible');
                }
            });
        });
    </script>
@endsection
