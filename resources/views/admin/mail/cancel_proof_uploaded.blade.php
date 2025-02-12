<!DOCTYPE html>
<html>
<head>
    <title>Yêu cầu hoàn tiền</title>
</head>
<body>
    <h1>Đã thanh toán tiền hoàn</h1>
    <p>Xin chào,</p>
    <p>Chúng tôi đã nhận được yêu cầu hoàn tiền của bạn.</p>
    <p><strong>Mã xác nhận:</strong> {{ $confirmationCode }}</p>
    <p>Số tiền hoàn: {{ number_format($refundAmount, 0, ',', '.') }} VNĐ.</p>

    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>
</html>
