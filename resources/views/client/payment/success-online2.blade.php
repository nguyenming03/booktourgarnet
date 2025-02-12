@extends('client.layouts.app')

@section('title', 'Thanh Toán Thành Công')

@section('content')
    <link rel="stylesheet" href="{{ url('client/booking/confirm.css') }}">
    <style>
        /* Modal styles */
        /* Modal styles */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .redirect-message {
            margin-top: 20px;
            font-size: 16px;
            color: #555;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            color: #333;
            cursor: pointer;
            font-weight: bold;
            transition: color 0.2s;
        }

        .close-button:hover {
            color: #ff0000;
        }
    </style>
    <!-- Pop-up Modal -->
    <div id="payment-modal" class="modal">
        <div class="modal-content">
            <!-- Close Button -->
            <span id="close-modal" class="close-button">&times;</span>

            <h2 class="form-title">Thanh Toán Thành Công</h2>
            <div class="payment-status">
                <p><strong>Phương thức thanh toán:</strong> <span>{{ $payment->payment_method }}</span></p>
                <p><strong>Mã giao dịch:</strong> <span>{{ $payment->transaction }}</span></p>
                <p><strong>Trạng thái thanh toán:</strong> <span>{{ $payment->trang_thai }}</span></p>
                <p><strong>Ngày thanh toán:</strong>
                    <span>{{ $payment->time = \Carbon\Carbon::parse($payment->time)->format('d/m/Y') }}</span></p>
                <p><strong>Số tiền thanh toán:</strong> <span>{{ number_format($payment->money, 0, ',', '.') }} VND</span>
                </p>
            </div>
            <h3 class="form-title">Thông Tin Cá Nhân và Vé Đã Chọn</h3>
            <div class="personal-info">
                <p><strong>Họ và Tên:</strong> <span>{{ $booking->name }}</span></p>
                <p><strong>Email:</strong> <span>{{ $booking->email }}</span></p>
                <p><strong>Số điện thoại:</strong> <span>{{ $booking->phone }}</span></p>
            </div>
            <div class="tour-info">
                <p><strong>Tour:</strong> <span>{{ $booking->tour_name }}</span></p>
                <p><strong>Ngày khởi hành:</strong>
                    <span>{{ $booking->start_date = \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}</span>
                </p>
                <p><strong>Số lượng:</strong> <span>{{ $booking->number_old + $booking->number_children }}</span></p>
                <p><strong>Giá vé:</strong> <span>{{ number_format($booking->total_money, 0, ',', '.') }} VND</span></p>
            </div>
            <p class="redirect-message">Bạn sẽ được chuyển về trang chủ sau <span id="redirect-timer">5</span> giây...</p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('payment-modal');
            modal.style.display = 'block';


            let countdown = 5;
            const timer = document.getElementById('redirect-timer');
            const redirectUrl = "{{ route('home') }}";

            const interval = setInterval(() => {
                countdown--;
                timer.textContent = countdown;

                if (countdown <= 0) {
                    clearInterval(interval);
                    window.location.href = redirectUrl;
                }
            }, 1000);
        });
    </script>
@endsection
