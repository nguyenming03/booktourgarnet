@extends('client.layouts.app')

@section('title', 'Hủy Thanh Toán')

@section('style')
    <style>
        .cancel-payment {
            text-align: center;
            margin: 50px auto;
            padding: 20px;
            max-width: 600px;
            background-color: #f8f9fa;
            /* Màu nền nhẹ nhàng */
            border: 1px solid #ddd;
            /* Đường viền tinh tế */
            border-radius: 10px;
            /* Góc bo tròn */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Đổ bóng */
        }

        .cancel-title {
            font-size: 2.5rem;
            color: #ff4d4f;
            /* Màu đỏ nổi bật */
            margin-bottom: 10px;
            font-weight: bold;
        }

        .cancel-message {
            font-size: 1rem;
            color: #6c757d;
            /* Màu chữ phụ */
            margin-bottom: 20px;
        }

        .btn-primary {
            text-decoration: none;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            /* Màu xanh chủ đạo */
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Màu xanh đậm hơn khi hover */
        }
    </style>
@section('content')
    <div class="cancel-payment">
        <h1 class="cancel-title">Bạn đã huỷ thanh toán hoặc số lượng tour đã hết </h1>
        <p class="cancel-message">Nếu đây là nhầm lẫn, bạn có thể quay lại và thử lại.Số tiền của bạn không bị ảnh hưởng hãy yên tâm</p>
        <a href="/" class="btn btn-primary">Quay lại trang chủ</a>
    </div>

@endsection
