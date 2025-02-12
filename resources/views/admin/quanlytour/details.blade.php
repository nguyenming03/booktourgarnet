{{-- <h5 class="card-title"><strong>Tài khoản đặt Tour:</strong> {{ $quanlytour->booking->user->name }}</h5> --}}
<p>
    <strong>Khách Hàng :</strong> {{ $quanlytour->booking->name }}
</p>
<p><strong>Thông tin Tour:</strong>{{ $quanlytour->booking->tour->name }}</p>
<p><strong>Số điện thoại: </strong>{{ $quanlytour->booking->phone }}</p>
<p><strong>Số tiền :</strong> {{ number_format($quanlytour->money, 0, ',', '.') }}đ</p>
<p><strong>Giao dịch :</strong> {{ $quanlytour->transcation }}</p>
<p><strong>Mã VNPAY :</strong> {{ $quanlytour->code_vnpay }}</p>
<p><strong>Mã ngân hàng :</strong> {{ $quanlytour->code_bank }}</p>
<p><strong>Thời gian :</strong> {{ $quanlytour->time }}</p>
<p><strong>Ghi chú :</strong> {{ $quanlytour->note }}</p>
<p><strong>Hình thức thanh toán:</strong>
    @if ($quanlytour->paymentMethod->id == 1)
        VNPAY
    @elseif ($quanlytour->paymentMethod->id == 2)
        Momo
    @elseif ($quanlytour->paymentMethod->id == 3)
        Thẻ Ngân Hàng
    @elseif ($quanlytour->paymentMethod->id == 4)
        Thanh Toán Trực Tiếp
    @endif
</p>
<p><strong>Trạng thái thanh toán :</strong> {{ $quanlytour->paymentStatus->name }}</p>
<p><strong>Trạng thái Tour :</strong> {{ $quanlytour->status->name }}</p>
<p><strong>Ngày tạo :</strong> {{ $quanlytour->created_at->format('d/m/Y H:i') }}</p>
<p><strong>Ngày cập nhật :</strong> {{ $quanlytour->updated_at->format('d/m/Y H:i') }}</p>
