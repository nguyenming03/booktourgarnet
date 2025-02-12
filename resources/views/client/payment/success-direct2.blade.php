@extends('client.layouts.app')

@section('title', 'Thanh Toán Thành Công')

@section('content')
    <link rel="stylesheet" href="{{ url('client/booking/confirm.css') }}">
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
            position: relative;
            text-align: center;
        }

        /* Close button styles */
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

        /* Redirect message styles */
        .redirect-message {
            margin-top: 20px;
            font-size: 16px;
            color: #555;
        }
    </style>
    <!-- Pop-up Modal -->
    <!-- Modal -->
    <div id="booking-modal" class="modal">
        <div class="modal-content">
            <!-- Close Button -->
            <span id="close-modal" class="close-button">&times;</span>

            <h2 class="form-title">Đặt Vé Thành Công</h2>
            <div class="booking-status">
                <p><strong>Trạng thái:</strong> <span>Đặt vé thành công - Chờ thanh toán</span></p>
                <p><strong>Hạn thanh toán:</strong>
                    <span>{{ \Carbon\Carbon::parse($booking->due_date)->format('d/m/Y H:i') }}</span>
                </p>
                <p><strong>Địa điểm thanh toán:</strong> <span>Văn phòng công ty tại {{ $paymentLocation }}</span></p>
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
                <p><strong>Giá vé:</strong> <span>{{ number_format($booking->total_money, 0, ',', '.') }} đ</span></p>
            </div>
            <p class="redirect-message">Bạn sẽ được chuyển về trang chủ sau <span id="redirect-timer">10</span> giây...</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('booking-modal');
            const closeModal = document.getElementById('close-modal');
            const timerElement = document.getElementById('redirect-timer');
            let countdown = 10;
            const redirectUrl = "{{ route('home') }}";
            let interval;

            // Hiển thị modal
            modal.style.display = 'flex';


            function startCountdown() {
                interval = setInterval(() => {
                    countdown--;
                    timerElement.textContent = countdown;

                    if (countdown <= 0) {
                        clearInterval(interval);
                        window.location.href = redirectUrl;
                    }
                }, 1000);
            }
            startCountdown();

            // Đóng modal khi nhấn nút X
            closeModal.addEventListener('click', () => {
                clearInterval(interval);
                modal.style.display = 'none';
            });
        });
    </script>
@endsection
