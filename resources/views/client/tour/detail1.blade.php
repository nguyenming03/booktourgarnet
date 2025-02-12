@extends('client.layouts.app')
@section('style')
    <style>
        /* container img */
        .tour-images {
            height: 500px;
            /* Đặt chiều cao cố định */
            overflow-y: auto;
            /* Thêm thanh cuộn dọc */
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
        }

        .tour-images img {
            width: 100%;
            /* Chiều rộng đầy đủ */
            margin-bottom: 10px;
            /* Khoảng cách giữa các ảnh */
            border-radius: 4px;
            transition: transform 0.2s ease-in-out;
        }

        .tour-images img:hover {
            transform: scale(1.05);
            /* Hiệu ứng phóng to khi hover */
        }

        .main-image img {
            max-width: 100%;
            border-radius: 4px;
            height: 500px;
            object-fit: cover;
            /* Hiệu ứng màu nền */
        }

        .tour-info {
            background-color: #f8f9fa;
            border-radius: 4px;
            padding: 15px;
        }

        .tour-price {
            font-size: 18px;
            color: #e74c3c;
        }

        .tour-price del {
            font-size: 14px;
            color: #6c757d;
        }

        .book-btn {
            background-color: #ff5722;
            color: #fff;
            border: none;
        }

        .book-btn:hover {
            background-color: #e64a19;
        }


        /* nav sticky */
        .sticky {
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, and Opera */
        }

        .custom-nav {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .custom-nav ul {
            white-space: nowrap;
            /* Ngăn xuống dòng */
            overflow-x: auto;
            /* Cho phép cuộn ngang */
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .custom-nav ul li {
            display: inline-block;
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease-in-out;
        }

        .custom-nav ul li:hover,
        .custom-nav ul li.active {
            border-bottom-color: #ff5722;
            /* Màu viền dưới khi active */
            color: #ff5722;
        }

        /* sau phần sticky */
        .tour-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            border-left: 4px solid #0056b3;
            padding-left: 10px;
        }

        .price-table {
            background-color: #fff9e6;
            border: 1px solid #ddd;
            width: 100%;
            margin-bottom: 20px;
        }

        .price-table th {
            background-color: #f6f3dc;
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }

        .price-table td {
            text-align: center;
            padding: 8px;
        }

        .note {
            font-size: 12px;
            font-style: italic;
            color: #666;
            margin-top: 10px;
        }

        .advice-box {
            background-color: #f0f8ff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .advice-box h4 {
            color: #0056b3;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .advice-box .hotline {
            font-size: 24px;
            color: #f56a00;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .advice-box input[type="text"] {
            width: 100%;
            margin-bottom: 10px;
            padding: 6px;
        }

        .advice-box button {
            background-color: #0056b3;
            color: #fff;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
        }

        .advice-box button:hover {
            background-color: #004494;
        }

        /* phần tour liên quan và box đặt tour */

        .related-title {
            font-size: 18px;
            font-weight: bold;
            color: #0056b3;
            margin-bottom: 20px;
        }

        .card {
            border: 1px solid #ddd;
            background-color: #fff;
            margin-bottom: 20px;
            text-align: center;
            padding: 10px;
        }

        .card img {
            width: 100%;
            height: auto;
        }

        .card-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            height: 50px;
        }

        .card-price {
            font-size: 16px;
            color: #f56a00;
            font-weight: bold;
            margin: 10px 0;
        }

        

        .highlight-card {
            border: 2px solid #ff6600;
            padding: 15px;
            text-align: left;
        }

        .highlight-card .price {
            color: #f56a00;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .highlight-card .btn-book {
            background-color: #ff6600;
            color: #fff;
            font-size: 16px;
            padding: 10px 15px;
            border: none;
            
        }

        .highlight-card .btn-book:hover {
            background-color: #e65c00;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Library</li>
            </ol>
        </nav>
        <h1>Tour Du lịch Hòa Bình</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- Tour Images -->
            <div class="col-md-3">
                <div class="row tour-images">
                    <div class="col-xs-6">
                        <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                            alt="Image 1" class="img-responsive">
                    </div>
                    <div class="col-xs-6">
                        <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                            alt="Image 2" class="img-responsive">
                    </div>
                    <div class="col-xs-6">
                        <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                            alt="Image 3" class="img-responsive">
                    </div>
                    <div class="col-xs-6">
                        <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                            alt="Image 4" class="img-responsive">
                    </div>
                    <div class="col-xs-6">
                        <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                            alt="Image 5" class="img-responsive">
                    </div>
                    <div class="col-xs-6">
                        <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                            alt="Image 6" class="img-responsive">
                    </div>
                    <div class="col-xs-6">
                        <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                            alt="Image 5" class="img-responsive">
                    </div>
                    <div class="col-xs-6">
                        <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                            alt="Image 6" class="img-responsive">
                    </div>
                    <div class="col-xs-6">
                        <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                            alt="Image 5" class="img-responsive">
                    </div>
                    <div class="col-xs-6">
                        <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                            alt="Image 6" class="img-responsive">
                    </div>
                </div>
            </div>

            <!-- Main Image -->
            <div class="col-md-6">
                <div class="main-image" >
                    <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg"
                        alt="Main Image" class="img-responsive">
                </div>
            </div>

            <!-- Tour Info -->
            <div class="col-md-3">
                <div class="tour-info">
                    <h5 class="tour-price">15.990.000đ <del>17.589.000đ</del></h5>
                    <div class="text-warning">
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                    </div>
                    <p><strong>Khởi hành từ:</strong> Hà Nội</p>
                    <p><strong>Điểm đến:</strong> Nước Ngoài Tết Dương Lịch 2025</p>
                    <p><strong>Lịch trình:</strong> 6 ngày 5 đêm</p>
                    <p><strong>Khởi hành:</strong> 26, 28, 29, 30/12/2024</p>
                    <ul>
                        <li>Khuyến mãi Đặt xa</li>
                        <li>Khuyến mãi Đặt theo Nhóm</li>
                        <li>Khuyến mãi cho Khách hàng thân thiết</li>
                        <li>Khuyến mãi cho Người Cao tuổi</li>
                    </ul>
                    <button class="btn book-btn btn-block">Đặt Tour Ngay</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Sticky Navbar -->
    <div class="custom-nav sticky">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <ul class="no-scrollbar">
                        <li class="active">Giới thiệu</li>
                        <li>Lịch trình</li>
                        <li>Bao gồm và điều khoản</li>
                        <li>Đánh giá Tour</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Tour Introduction -->
        <div class="row">
            <div class="col-md-9">
                <h3 class="tour-title">Giới thiệu</h3>
                <p>Tour du lịch Thành Đô - Cửu Trại Câu - Trượt tuyết Gia Cô Sơn 6 ngày 5 đêm từ Hà Nội vào dịp Tết Dương
                    Lịch là lựa chọn hoàn hảo để khám phá Trung Quốc vào mùa đông. Hãy cùng khám phá vẻ đẹp kỳ ảo của Cửu
                    Trại Câu và tận hưởng cảm giác trượt tuyết tuyệt vời tại Gia Cô Sơn, mang đến cho bạn một kỳ nghỉ đáng
                    nhớ đầu năm mới.</p>
                <!-- Price Table -->
                <table class="table table-bordered price-table">
                    <thead>
                        <tr>
                            <th>LỊCH KHỞI HÀNH 2024</th>
                            <th>GIÁ NGƯỜI LỚN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>26/12</td>
                            <td>15.990.000 VNĐ</td>
                        </tr>
                        <tr>
                            <td>28, 29, 30/12</td>
                            <td>16.990.000 VNĐ</td>
                        </tr>
                    </tbody>
                </table>
                <p class="note">*Lưu ý: Giá chỉ từ và phụ thuộc vào tình trạng vé máy bay. Quý khách liên hệ 19003440 để
                    được hỗ trợ chi tiết.</p>
            </div>
            <!-- Advice Box -->
            <div class="col-md-3">
                <div class="advice-box">
                    <h4>Gọi ngay để được tư vấn</h4>
                    <p class="hotline">1900 3440</p>
                    <input type="text" placeholder="SĐT của tôi" class="form-control">
                    <button>Gửi</button>
                    <p>PYS Travel sẽ liên hệ với bạn</p>
                </div>
                
            </div>
        </div>
    </div>
    <div class="container mb-">
        <div class="row">
            <!-- Suggested Tours Section -->
            <div class="col-md-9">
                <h4 class="related-title">Có thể bạn quan tâm</h4>
                <div class="row">
                    <!-- Tour Card 1 -->
                    <div class="col-sm-4">
                        <div class="card">
                            <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg" alt="Tour 1">
                            <p class="card-title">Tour Trung Quốc: Thành Đô - Cửu Trại Câu - Trượt tuyết Gia Cô Sơn 5 ngày 4
                                đêm</p>
                            <p class="card-price">19.990.000đ</p>
                            <button class="btn btn-danger">Xem ngay</button>
                        </div>
                    </div>
                    <!-- Tour Card 2 -->
                    <div class="col-sm-4">
                        <div class="card">
                            <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg" alt="Tour 2">
                            <p class="card-title">Tour Trung Quốc: Thành Đô - Cửu Trại Câu - Gia Cô Sơn 6 ngày 5 đêm</p>
                            <p class="card-price">14.990.000đ</p>
                            <button class="btn btn-danger">Xem ngay</button>
                        </div>
                    </div>
                    <!-- Tour Card 3 -->
                    <div class="col-sm-4">
                        <div class="card">
                            <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg" alt="Tour 3">
                            <p class="card-title">Tour Trung Quốc: Thành Đô - Cửu Trại Câu - Lạc Sơn 6 ngày 5 đêm</p>
                            <p class="card-price">14.990.000đ</p>
                            <button class="btn btn-danger">Xem ngay</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Highlighted Tour Section -->
            <div class="col-md-3">
                <div class="highlight-card">
                    <img src="https://anhcute.net/wp-content/uploads/2024/10/Anh-hinh-chibi-Naruto-cute.jpg" alt="Highlight Tour" class="img-responsive">
                    <h4>Tour Trung Quốc: Thành Đô - Cửu Trại Câu - Gia Cô Sơn</h4>
                    <ul>
                        <li>Lịch trình: 6 ngày 5 đêm</li>
                        <li>Khởi hành: Hà Nội</li>
                    </ul>
                    <p class="price">15.990.000đ/khách</p>
                    <center>

                        <button class="btn btn-danger">Đặt tour ngay</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
@endsection
