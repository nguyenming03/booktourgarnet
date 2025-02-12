<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin chi tiết đơn đặt tour</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            margin: 40px;
            line-height: 1.6;
            color: #333;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            color: #0056b3;
            text-transform: uppercase;
            margin-bottom: 20px;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .info-table th, .info-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .info-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        .highlight {
            font-weight: bold;
            color: #d9534f;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Thông tin chi tiết đơn đặt tour</h1>
    <table class="info-table">
        <tr>
            <th>Tên khách hàng</th>
            <td>{{ $customer_name }}</td>
        </tr>
        <tr>
            <th>Tour</th>
            <td>{{ $name_tour }}</td>
        </tr>
        <tr>
            <th>Số Tiền</th>
            <td class="highlight">{{ number_format($money, 0, ',', '.') }} VNĐ</td>
        </tr>
        <tr>
            <th>Ngày khởi hành</th>
            <td>{{ $start_date }}</td>
        </tr>
        <tr>
            <th>Hành Trình</th>
            <td>{{ $schedule }}</td>
        </tr>
        <tr>
            <th>Trạng thái thanh toán</th>
            <td>{{ $payment_status }}</td>
        </tr>
        <tr>
            <th>Hình thức thanh toán</th>
            <td>{{ $payment_method }}</td>
        </tr>
        @if (!empty($code_vnpay))
        <tr>
            <th>Mã Thanh Toán</th>
            <td>{{ $code_vnpay }}</td>
        </tr>
        @endif
        <tr>
            <th>Thời Gian Đặt</th>
            <td>{{ $time }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Cảm ơn quý khách đã lựa chọn dịch vụ của chúng tôi. Chúc quý khách có một chuyến đi vui vẻ và ý nghĩa!</p>
    </div>
</body>
</html>
