@extends('client.layouts.app')

@section('title', 'Chọn phương thức thanh toán')

@section('content')
    <link rel="stylesheet" href="{{ url('client/booking/confirm.css') }}">
    <section class="payment-section">
        <div class="container">
            <div class="row">
                <!-- Left column: Payment Method -->
                <div class="col-md-6">
                    <div class="payment-method-wrapper">
                        <h2 class="form-title">Chọn Phương Thức Thanh Toán</h2>
                        <form id="payment-form" method="POST" class="payment-form">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}"> <!-- Booking ID -->
                            <input type="hidden" name="money" value="{{ $booking->total_money }}"> <!-- Tổng tiền -->
                            <input type="hidden" name="vnp_response_code" value="{{ old('vnp_response_code') }}">
                            <!-- Mã phản hồi VNPay -->
                            <input type="hidden" name="transaction" value="{{ old('transaction') }}"> <!-- Mã giao dịch -->
                            <input type="hidden" name="code_vnpay" value="{{ old('code_vnpay') }}"> <!-- Mã VNPay -->
                            <input type="hidden" name="code_bank" value="{{ old('code_bank') }}"> <!-- Mã ngân hàng -->
                            <input type="hidden" name="trang_thai" value="{{ old('trang_thai') }}">
                            <!-- Trạng thái thanh toán -->
                            <input type="hidden" name="redirect">
                            <input type="hidden" name="coupon" value="{{ $code }}">


                            <div class="payment-options">
                                {{-- <div class="payment-option">
                                    <input type="radio" id="credit-card" name="payment_method_id" value="3">
                                    <label for="credit-card">
                                        <span>Thẻ tín dụng</span>
                                        <img src="https://timo.vn/wp-content/uploads/dang-ky-the-tin-dung-online-1.jpg" alt="Thẻ tín dụng" class="payment-img">
                                    </label>
                                </div> --}}

                                <div class="payment-option">
                                    <input type="radio" id="vnpay" name="payment_method_id" value="1">
                                    <label for="vnpay">
                                        <span>VNPay</span>
                                        <img src="https://vnpay.vn/s1/statics.vnpay.vn/2023/9/06ncktiwd6dc1694418196384.png"
                                            alt="MoMo" class="payment-img">
                                    </label>
                                </div>

                                {{-- <div class="payment-option">
                                        <input type="radio" id="bank-transfer" name="payment_method_id" value="2">
                                        <label for="bank-transfer">
                                            <span>Chuyển khoản ngân hàng</span>
                                            <img src="https://admin.tamlyvietphap.vn/uploaded/Images/Original/2020/10/16/logo_vietcombank_1610091313.jpg" alt="Chuyển khoản ngân hàng" class="payment-img">
                                            <img src="https://scontent.iocvnpt.com/resources/portal/Images/CTO/superadminportal.cto/TienIch/NganHang/VietinBank/vietinbank_637018943312743351.jpg" alt="Chuyển khoản ngân hàng" class="payment-img">
                                        </label>
                                    </div> --}}

                                <div class="payment-option">
                                    <input type="radio" id="cash-on-delivery" name="payment_method_id" value="4">
                                    <label for="cash-on-delivery">
                                        <span>Thanh toán tại địa điểm check-in</span>
                                        <img src="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/logo6d1d.png?1705894518705') }}"
                                            alt="Thanh toán khi nhận hàng" class="payment-img">
                                    </label>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn-submit-payment">Thanh Toán</button>
                            </div>
                        </form>

                        <script>
                            document.getElementById('payment-form').addEventListener('submit', function(event) {
                                // Kiểm tra phương thức thanh toán được chọn
                                const paymentMethod = document.querySelector('input[name="payment_method_id"]:checked');

                                if (paymentMethod) {
                                    // Nếu chọn thanh toán VNPay
                                    if (paymentMethod.value == 1) {
                                        this.action = '{{ route('payment.vnpay') }}';
                                    }
                                    // Nếu chọn thanh toán trực tiếp (store)
                                    else if (paymentMethod.value == 4) {
                                        this.action = '{{ route('payment.store') }}';
                                    }
                                } else {
                                    event.preventDefault(); // Ngừng form submit nếu không có phương thức thanh toán được chọn
                                    alert('Vui lòng chọn phương thức thanh toán');
                                }
                            });
                        </script>





                    </div>


                </div>

                <!-- Right column: Personal and Tour Information -->
                <div class="col-md-6">
                    <div class="info-wrapper">
                        <h3 class="form-title">Thông Tin Cá Nhân và Vé Đã Chọn</h3>
                        <div class="personal-info">
                            <p><strong>Họ và Tên:</strong> <span id="user-name">{{ $booking->name }}</span></p>
                            <p><strong>Email:</strong> <span id="user-email">{{ $booking->email }}</span></p>
                            <p><strong>Số điện thoại:</strong> <span id="user-phone">{{ $booking->phone }}</span></p>
                        </div>
                        <div class="tour-info">
                            <p><strong>Tour:</strong> <span id="selected-tour">{{ $tourName }}</span></p>
                            <p><strong>Ngày khởi hành:</strong> <span
                                    id="selected-date">{{ $booking->start_date = \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}</span>
                            </p>
                            <p><strong>Số lượng:</strong> <span
                                    id="selected-quantity">{{ $booking->number_old + $booking->number_children }}</span>
                            </p>
                            <p><strong>Giá vé:</strong> <span
                                    id="selected-price">{{ number_format($booking->total_money, 0, ',', '.') }} đ</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Thành công!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Thất bại!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
