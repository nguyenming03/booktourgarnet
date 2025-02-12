<p>
  <strong>Khách Hàng :</strong> {{ $quanlytour->booking->name }}
</p>
<p><strong>Thông tin Tour:</strong>{{ $quanlytour->booking->tour->name }}</p>
<p><strong>Số điện thoại: </strong>{{ $quanlytour->booking->phone }}</p>
<p><strong>Số tiền :</strong> {{ $quanlytour->money }}</p>
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
<h5>Thông Tin Hoàn Tiền</h5>
<p><strong>Tên Tài Khoản :</strong> {{ $quanlytour->booking->account_name }}</p>
<p><strong>Số Tài Khoản :</strong> {{ $quanlytour->booking->account_number }}</p>
<p><strong>QR Tài Khoản :</strong> {{ $quanlytour->booking->qr_code }}</p>
<p><strong>Lý Do Hủy :</strong> {{ $quanlytour->booking->phone }}</p>
