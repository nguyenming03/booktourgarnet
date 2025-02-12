@extends('client.layouts.app')
@section('title')
    Chi Tiết Đơn Hàng
@endsection
@section('style')
    <style>
        .modal-header {
            background-color: #f8f9fa;
            padding: 20px 30px;
            border-bottom: 1px solid #dee2e6;
            border-radius: 10px 10px 0 0;
            /* display: flex; */
            justify-content: space-between;
            align-items: center;
        }

        .modal-title-2 {
            font-weight: 600;
            color: #333;
            margin-bottom: 0;

        }

        .modal-header .close {
            background: none;
            border: none;
            color: #000000;
            font-size: 2.5rem;
            cursor: pointer;
            padding: 0;
            margin-top: -26px;
        }

        .modal-header .close:hover {
            color: #dc3545;
            transition: color 0.3s ease;
        }
    </style>
@endsection
@section('content')
    <br>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="text-center">Chi tiết đơn hàng</h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Thông tin khách hàng</strong>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <p><strong>Tên khách hàng:</strong> {{ $payment->booking->name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $payment->booking->email ?? 'N/A' }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $payment->booking->phone ?? 'N/A' }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $payment->booking->address ?? 'N/A' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Ngày đặt tour:</strong>
                            {{ $payment->booking->date_booking ? date('d-m-Y', strtotime($payment->booking->date_booking)) : 'N/A' }}
                        </p>
                        <p><strong>Số lượng người lớn:</strong> {{ $payment->booking->number_old ?? 'N/A' }}</p>
                        <p><strong>Số lượng trẻ em:</strong> {{ $payment->booking->number_children ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
          
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Tour</strong>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên tour</th>
                        <th>Hình thức thanh toán</th>
                        <th>Trạng thái thanh toán</th>
                        <th>Đơn hàng</th>
                        <th>Giá</th>
                        <th>Giá</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $payment->booking->tour->name ?? 'N/A' }}</td>
                        <td>
                            @if ($payment->paymentMethod->id == 1)
                                VNPAY
                            @elseif ($payment->paymentMethod->id == 2)
                                Momo
                            @elseif ($payment->paymentMethod->id == 3)
                                Thẻ Ngân Hàng
                            @elseif ($payment->paymentMethod->id == 4)
                                Thanh Toán Trực Tiếp
                            @endif
                        </td>
                        <td>{{ $payment->paymentStatus->name ?? 'N/A' }}</td>
                        <td>{{ $payment->status->name ?? 'N/A' }}</td>
                        <td>{{ number_format($payment->money, 0, ',', '.') }} đ</td>
                        <td> <a href="javascript:void(0);" class="btn btn-success mb-3" data-toggle="modal" data-target="#refundRequestModal1">
                            Xem chi tiết chuyến đi
                        </a></td>
                    </tr>
                </tbody>
                @if ($payment->status_id == 13)
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Tiền hoàn:</th>
                            <th>{{ number_format($payment->refund_amount ?? 0, 0, ',', '.') }} đ</th>
                        </tr>
                    </tfoot>
                @else
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Tổng cộng:</th>
                            <th>{{ number_format($payment->money, 0, ',', '.') }} đđ</th>
                        </tr>
                    </tfoot>
                @endif
               
            </table>


        </div>

        @if (in_array($payment->status_id, [1, 2, 5]))
    @if ($payment->payment_status_id == 2)
        <div class="alert alert-warning text-center mb-3">
            <span>Tour đã thanh toán. Vui lòng cân nhắc kỹ trước khi hủy!</span>
        </div>
    @endif
    <a href="javascript:void(0);" class="btn btn-warning mb-3" data-toggle="modal" data-target="#cancelOrderModal">
        Hủy Tour
    </a>
@elseif ($payment->status_id == 13)
    <div class="alert alert-danger text-center">
        <span>Tour đã bị hủy</span>
    </div>
    @if ($payment->payment_method_id == 1 && $payment->payment_status_id == 2)
        <a href="javascript:void(0);" class="btn btn-success mb-3" data-toggle="modal" data-target="#refundRequestModal">
            Yêu cầu hoàn tiền
        </a>
    @endif
@elseif ($payment->status_id == 9)
    <div class="alert alert-info text-center">
        <span>Tour đã bị từ chối hủy</span>
    </div>
@endif


        <a href="{{ url('/') }}" class="btn btn-primary">Quay lại trang chủ</a>

        <!-- Modal hủy đơn hàng -->
        <div class="modal fade" id="cancelOrderModal" tabindex="-1" role="dialog" aria-labelledby="cancelOrderLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title-2" id="cancelOrderLabel">Hủy đơn hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('usser.cancelOrder', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="ly_do_huy">Lý do hủy đơn hàng</label>
                                <select name="ly_do_huy" id="ly_do_huy" class="form-control" required>
                                    <option value="" disabled selected>Chọn lý do</option>
                                    <option value="Thay đổi kế hoạch cá nhân">Thay đổi kế hoạch cá nhân</option>
                                    <option value="Không đủ tài chính để thanh toán">Không đủ tài chính để thanh toán
                                    </option>
                                    <option value="Tìm được giá tốt hơn ở nơi khác">Tìm được giá tốt hơn ở nơi khác</option>
                                    <option value="Không hài lòng với thông tin về tour">Không hài lòng với thông tin về
                                        tour</option>
                                    <option value="Lịch trình không phù hợp với kế hoạch cá nhân">Lịch trình không phù hợp
                                        với kế hoạch cá nhân</option>
                                    <option value="Đã đặt nhầm tour hoặc sai thông tin">Đã đặt nhầm tour hoặc sai thông tin
                                    </option>
                                    <option value="Không nhận được sự hỗ trợ từ nhà cung cấp">Không nhận được sự hỗ trợ từ
                                        nhà cung cấp</option>
                                    <option value="Thay đổi quyết định sau khi tham khảo ý kiến gia đình/bạn bè">Thay đổi
                                        quyết định sau khi tham khảo ý kiến gia đình/bạn bè</option>
                                    <option value="Đã phát sinh các vấn đề sức khỏe hoặc cá nhân">Đã phát sinh các vấn đề
                                        sức khỏe hoặc cá nhân</option>
                                    <option value="Không còn nhu cầu sử dụng dịch vụ">Không còn nhu cầu sử dụng dịch vụ
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer" style="">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="refundRequestModal" tabindex="-1" role="dialog" aria-labelledby="refundRequestLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row w-100">
                            <h5 class="modal-title-2" id="refundRequestLabel">Yêu cầu hoàn tiền</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('usser.submitRefundRequest', $payment->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="bank">Ngân Hàng</label>
                                <select name="bank" id="bank" class="form-control" required>
                                    <option value="">Chọn ngân hàng</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="account_number">Số tài khoản ngân hàng</label>
                                <input type="text" name="account_number" id="account_number" class="form-control"
                                    placeholder="Nhập số tài khoản" required>
                            </div>

                            <div class="form-group">
                                <label for="account_name">Tên tài khoản ngân hàng</label>
                                <input type="text" name="account_name" id="account_name" class="form-control"
                                    placeholder="Nhập tên tài khoản" required>
                            </div>

                            <!-- Ảnh QR (nếu có) -->
                            <div class="form-group">
                                <label for="qr_code">Tải lên ảnh QR (nếu có)</label>
                                <input type="file" name="qr_code" id="qr_code" class="form-control"
                                    accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-danger">Gửi yêu cầu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="refundRequestModal1" tabindex="-1" role="dialog" aria-labelledby="refundRequestLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row w-100">
                        <h5 class="modal-title-2" id="refundRequestLabel">Lịch trình chi tiết cho chuyến đi của bạn</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
    
                <div class="modal-body">
                    <p>Kính gửi Quý khách hàng,</p>
                    <p>Chúng tôi rất vui mừng gửi đến Quý khách lịch trình chi tiết cho chuyến đi đã đặt. Dưới đây là thông tin cụ thể:</p>
    
                    <!-- Thông tin lịch trình -->
                    <div class="form-group">
                        <label><strong>Tên tour:</strong></label>
                        <p>{{ $payment->booking->tour->name }}</p>
                    </div>
    
                    <div class="form-group">
                        <label><strong>Ngày khởi hành:</strong></label>
                        <p>{{ $payment->booking->start_date }}</p>
                    </div>
    
                    <div class="form-group">
                        <label><strong>Ngày kết thúc(Dự Kiến):</strong></label>
                        <p>{{ $payment->booking->end_date }}</p>
                    </div>
    
                    <div class="form-group">
                        <label><strong>Thời gian tập trung:</strong></label>
                        <p>7:30 sáng ngày {{ $payment->booking->start_date }} Trụ sở Garnet Tại 12 Hàng Mã , Tây Hồ , Hà Nội </p>
                    </div>
    
                    
    
                    <!-- Lịch trình hàng ngày -->
                    {{-- <div class="form-group">
                        <label><strong>Chi tiết lịch trình:</strong></label>
                        <ul>
                            @foreach($tour->itinerary as $day => $details)
                                <li>
                                    <strong>Ngày {{ $day + 1 }}:</strong> {{ $details['title'] }}  
                                    <p>{{ $details['description'] }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div> --}}
    <h4>Hỗ Trợ</h4>
                    <p>Nếu Quý khách có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua 0862001730 để được hỗ trợ.</p>
                    <p>Chúc Quý khách có một chuyến đi thật tuyệt vời!</p>
    
                    <p>Trân trọng,<br><strong>[Garnet]</strong></p>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    
    </div>
    <br>
    <br>
@endsection
@section('script')
    <script>
        fetch('https://api.vietqr.io/v2/banks')
            .then(response => response.json())
            .then(response => {

                const banks = response.data;
                if (Array.isArray(banks)) {

                    const bankSelect = document.getElementById('bank');


                    banks.forEach(bank => {
                        const option = document.createElement('option');
                        option.value = bank.name + ' - ' + bank.shortName;
                        option.textContent = bank.name + ' - ' + bank.shortName;
                        bankSelect.appendChild(option);
                    });
                } else {
                    console.error('Error: ', response.data);
                }
            })
            .catch(error => console.error('Có lỗi xảy ra:', error));
    </script>
@endsection
