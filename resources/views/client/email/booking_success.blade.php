<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
</head>
<body>
    <h1>Cảm ơn bạn đã tin tưởng Garnet, {{ $data['user'] }}!</h1>
    <p>Dưới đây là thông tin đặt tour của bạn:</p>

    <ul>
        <li><strong>Tên tour:</strong> {{ $data['name_tour'] }}</li>
        <!-- Hiển thị ảnh với CID -->
        <li><img src="cid:tour.webp" alt="Tour Image" style="max-width: 100%; height: auto;"></li>
        <li><strong>Ngày:</strong> {{ $data['booked_time'] }}</li>
        <li><strong>Khách hàng:</strong> {{ $data['guests'] }}</li>
        <li><strong>Tổng tiền:</strong> {{ number_format($data['money'],0,'','.') }} VNĐ</li>
    </ul>

    <p><strong>Chi tiết thanh toán:</strong></p>
    <ul>
        <li><strong>Tổng tiền:</strong> {{ number_format($data['money'],0,'','.') }} VNĐ</li>
        <li><strong>Phương thức thanh toán:</strong> {{ $data['payment_method'] }}</li>
        <li><strong>Mã giao dịch:</strong> {{ $data['code'] }}</li>
        <li><strong>Trạng thái thanh toán:</strong> {{ $data['payment_status'] }}</li>
        <li><strong>Ngày bắt đầu tour:</strong> {{ $data['start_date'] }}</li>
        <li><strong>Thời gian thanh toán:</strong> {{ $data['booked_time'] }}</li>
    </ul>

    @if (!empty($data['note']))
        <p><strong>Note:</strong> {{ $data['note'] }}</p>
    @endif

    <p>Cảm ơn bạn đã dùng dịch vụ</p>
</body>
</html>
