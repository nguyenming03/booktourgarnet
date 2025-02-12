@extends('client.layouts.app')

@section('title', 'Đặt Tour Du Lịch')
@section('style')
    <style>
        /* CSS cho checkbox và label */
        .form-group label {
            display: flex;
            align-items: center;
            font-size: 16px;
            font-weight: normal;
            color: #333;
            margin-bottom: 10px;
            cursor: pointer;
        }

        #agree-policy {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            cursor: pointer;
            appearance: none;
            /* Loại bỏ kiểu mặc định */
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            position: relative;
            display: inline-block;
            vertical-align: middle;
            transition: all 0.2s ease;
        }

        #agree-policy:checked {
            border-color: #28a745;
            background-color: #28a745;
        }

        #agree-policy:checked::before {
            content: '✔';
            font-size: 14px;
            color: #fff;
            position: absolute;
            left: 3px;
            top: -2px;
        }

        .form-group a {
            color: #007bff;
            text-decoration: none;
        }

        .form-group a:hover {
            text-decoration: underline;
        }

        /* Tin nhắn lỗi */
        #policy-message {
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
@endsection
@section('content')
    <link rel="stylesheet" href="{{ url('client/booking/booking.css') }}">
    <section class="booking-section">
        <div class="container">
            <div class="row">
                <!-- Left column: Personal Information -->
                <div class="col-md-6">
                    <div class="booking-form-wrapper">
                        <h2 class="form-title">Đặt chỗ của tôi</h2>
                        <h5 class="form-title1">Điền thông tin và xem lại đặt chỗ</h5>
                        <form action="/booking" method="POST" class="booking-form" id="booking-form">
                            @csrf


                            <div class="form-group">
                                <label for="name">Họ và Tên</label>
                                <input type="text" id="name" name="name" placeholder="Nhập tên của bạn"
                                    value="{{ auth()->check() ? auth()->user()->name : old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Nhập email của bạn"
                                    value="{{ auth()->check() ? auth()->user()->email : old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại"
                                    value="{{ auth()->check() ? auth()->user()->phone : old('phone') }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" id="address" name="address" placeholder="Nhập địa chỉ của bạn"
                                    value="{{ auth()->check() ? auth()->user()->address : old('address') }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">Mã giảm giá (Nếu có):</label>
                                <input type="text" id="coupon" name="coupon" />
                                <p id="coupon-message" style="color: red; font-weight: bold;"></p>
                                @error('coupon')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {!! NoCaptcha::display() !!}
                            @error('g-recaptcha-response')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="total">Tổng tiền:</label>
                                <p style="color: blue; font-weight: bolder" id="total-price-display">0₫</p>
                                <input type="hidden" id="total-price" name="total_money">
                                <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
                                <input type="hidden" id="tour-name" name="tour_name">
                                <input type="hidden" id="departure-date" name="start_date">
                                <input type="hidden" id="departure-enddate" name="end_date">
                                <input type="hidden" id="quantity" name="quantity">
                                <input type="hidden" id="price" name="price">
                                <input type="hidden" id="adults" name="number_old">
                                <input type="hidden" id="children" name="number_children">

                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" id="agree-policy" name="agree_policy">
                                    Tôi đồng ý với <a href="javascript:void(0);" id="show-policy" style="color: blue;">chính
                                        sách của chúng tôi.</a>

                                </label>

                                @error('agree_policy')
                                    <p id="policy-message" style="color: red; font-weight: bold; ">{{ $message }}</p>
                                @enderror

                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn-submit" id="submit-button" >Tiếp tục</button>
                            </div>

                        </form>

                    </div>
                </div>

                <!-- Right column: Selected Tour Information -->
                <div class="col-md-6">
                    <div class="selected-tour-info">
                        <h3>Thông tin vé bạn đã chọn</h3>
                        <div class="tour-horizontal-layout">
                            <div class="tour-image">
                                <img src="{{ Storage::url($tour->image) }}" alt="Ảnh tour" id="tour-image">
                            </div>
                            <div class="tour-details">
                                <p><strong>Tour:</strong> <span id="selected-tour"></span></p>
                                <div class="highlight-info">
                                    <p><strong>Ngày khởi hành:</strong> <span id="selected-date"></span></p>
                                    <p><strong>Ngày Kết Thúc(Dự Kiến):</strong> <span id="selected-enddate"></span></p>
                                    <p><strong>Số lượng:</strong> <span id="selected-quantity"></span></p>
                                </div>
                                <p><strong>Giá vé:</strong> <span id="selected-price">1,500,000 đ</span></p>
                            </div>
                        </div>
                        {{-- <p>Để biết thêm chi tiết vé, <a href="#" style="color: blue">Vui lòng xem tại đây</a></p> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="tour-policy-content" id="tour-policy-content" style="display: none;">
        <div class="main-project__tab--content"style="margin-top: 5%">
            <div class="product-promotions-list">
                <h2 class="product-promotions-list-title">Chính sách Tour</h2>
                <div class="product-promotions-list-content">

                    <strong>* Giá tour bao gồm:</strong><br />

                    <p><i>Giá tour không bao gồm:</i> <br>
                        - Chi phí làm hộ chiếu, các chương trình tự chọn, nước uống, giặt ủi, điện
                        thoại... và các chi phí cá nhân khác của khách ngoài chương trình.<br>
                        - Hành lý quá cước, chi phí dời ngày và đổi chặng bay theo qui định của hàng
                        không.<br>
                        - Phí phòng đơn (dành cho khách yêu cầu ở phòng đơn).<br>
                        - Tiền bồi dưỡng cho HDV và lái xe địa phương (8 CAD/ khách/ ngày).<br>

                        <strong> * Điều khoản hủy tour (Thời gian hủy tour được tính theo tất cả các
                            ngày trong
                            tuần).</strong><br>
                        <i> Sau khi đặt tour thành công:</i><br>

                        1. Thanh toán online: <br>

                        -Nếu quý khách báo hủy tour, vui lòng liên hệ với chúng
                        tôi qua số điện thoại: <b>096171690</b> hoặc <b>email: garnet@gmail.com</b>
                        để được xác
                        nhận hủy tour và hoàn tiền theo chính sách của chúng tôi.<br>

                        2. Thanh toán trực tiếp: <br>
                        - Quý khách hủy tour trước khi chúng tôi xác nhận đơn
                        đặt tour.<br>

                        <i style="color: red"><b>*Lưu ý:</b> Nếu quý khách đã thanh toán trực tiếp
                            tại
                            trung tâm của chúng tôi,
                            sau khi đơn đặt tour đã được xác nhận, vui lòng liên hệ với chúng tôi
                            qua số
                            điện thoại: <b>096171690</b> hoặc email: <b>email:
                                garnet@gmail.com</b>.</i><br>

                        <b>* Chính sách hoàn tiền:</b><br>

                        - Hủy tour trong vòng <b>24h sau khi đặt tour</b> (trong trường hợp đơn hàng
                        chưa
                        được xác nhận)<b> hoàn tiền 100% giá tour.</b><br>

                        - Hủy tour trong vòng <b>24h sau khi đặt tour</b> (trong trường hợp đơn hàng
                        đã được xác nhận) <b>hoàn tiền 95% giá tour.</b><br>

                        - Hủy tour trước ngày tour <b>bắt đầu 24h hoàn tiền 80% giá tour.</b><br>

                        - Hủy tour khi tour <b>đang diễn ra hoàn tiền 0% giá tour.</b><br>
                    </p>

                </div>
            </div>
            <!-- Nút đóng modal -->

        </div>
        <button onclick="closeTourPolicy()" class="btn btn-danger"
            style="position: absolute; top: 20px; right: 20px;">Đóng</button>
    </div>

    <style>
        .tour-no-content {
            display: none;
        }

        .tour-policy-content {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .tour-policy-content.show {
            display: flex;
            opacity: 1;
            transform: scale(1);
        }


        .main-project__tab--content {
            background-color: white;
            padding: 20px;
            max-width: 800px;
            margin: auto;
            border-radius: 10px;
            overflow: auto;
            /* Cho phép cuộn nội dung nếu cần */
            max-height: 80vh;
            /* Điều chỉnh chiều cao của nội dung */
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }


        .product-promotions-list-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .product-promotions-list-content {
            font-size: 16px;
            line-height: 1.6;
        }
    </style>


    <script>
        // Mở modal
        function openTourPolicy() {
            var tourPolicyContent = document.getElementById('tour-policy-content');
            tourPolicyContent.classList.add('show');
        }

        // Đóng modal
        function closeTourPolicy() {
            var tourPolicyContent = document.getElementById('tour-policy-content');
            tourPolicyContent.classList.remove('show');
            setTimeout(() => {
                tourPolicyContent.style.display = 'none'; // Ẩn hoàn toàn sau hiệu ứng
            }, 300); // Đợi hiệu ứng hoàn tất
        }

        // Sự kiện mở modal
        document.getElementById('show-policy').addEventListener('click', function() {
            var tourPolicyContent = document.getElementById('tour-policy-content');
            tourPolicyContent.style.display = 'flex'; // Hiển thị modal
            setTimeout(() => {
                tourPolicyContent.classList.add('show'); // Thêm hiệu ứng mở
            }, 10);
        });

        // Đóng modal khi click ra ngoài
        document.getElementById('tour-policy-content').addEventListener('click', function(event) {
            if (event.target === this) {
                closeTourPolicy();
            }
        });
    </script>

    {{-- @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: '@foreach ($errors->all() as $error) {{ $error }} @endforeach',
            });
        </script>
    @endif --}}

    <?php
    
    $coupons = isset($coupons) ? $coupons : null;
    //  var_dump($coupons);
    //  dd($coupons);
    ?>
    <?php
    // echo '<pre>';
    // print_r($coupons->toArray());
    // echo '</pre>';
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {


            // Lấy thông tin từ sessionStorage
            const bookingInfo = JSON.parse(sessionStorage.getItem('selectedTourInfo'));
            const bookingInfo1 = JSON.parse(sessionStorage.getItem('tourBooking'));

            if (bookingInfo && bookingInfo1) {
                const adults = bookingInfo1.adults || 0;
                const children = bookingInfo1.children || 0;

                document.getElementById('selected-quantity').textContent =
                    `${adults} Người lớn, ${children} Trẻ em`;
                console.log(bookingInfo.startDate);

                // Hiển thị thông tin trong giao diện
                document.getElementById('selected-tour').textContent = bookingInfo.tourName || 'Chưa xác định';
                document.getElementById('selected-date').textContent = bookingInfo.startDate || 'Chưa xác định';
                document.getElementById('selected-enddate').textContent = bookingInfo.startDate || 'Chưa xác định';
                document.getElementById('selected-price').textContent = bookingInfo.totalPrice ?
                    bookingInfo.totalPrice.toLocaleString("vi-VN") + "₫" :
                    '0 đ';
                document.getElementById('total-price-display').textContent = bookingInfo.totalPrice ?
                    bookingInfo.totalPrice.toLocaleString("vi-VN") + "₫" :
                    '0 đ';

                // Gán giá trị vào các trường ẩn trong form
                document.getElementById('tour-name').value = bookingInfo.tourName || '';
                document.getElementById('departure-date').value = bookingInfo.startDate || '';
                document.getElementById('departure-enddate').value = bookingInfo.endDate || '';
                document.getElementById('quantity').value = `${adults}-${children}` || '';
                document.getElementById('price').value = bookingInfo.totalPrice || '';
                document.getElementById('total-price').value = bookingInfo.totalPrice || '';

                // Gán số khách vào input ẩn
                document.getElementById('adults').value = adults;
                document.getElementById('children').value = children;

                // Cập nhật tổng tiền vào trường hiển thị tổng
                const totalPrice = bookingInfo.totalPrice || 0;

                //document.getElementById("totalPriceDisplay").textContent = totalPrice.toLocaleString("vi-VN") + "₫";

                //document.getElementById("totalPriceHidden").value = totalPrice;



            } else {
                alert('Không có thông tin đặt tour. Vui lòng quay lại trang trước.');
                window.location.href = '/';
            }


            const coupons = <?php echo json_encode($coupons); ?>;
            console.log("Danh sách:", coupons);

            const couponInput = document.getElementById('coupon');
            const totalPriceDisplay = document.getElementById('total-price-display');
            const totalPriceHidden = document.getElementById('total-price');
            const couponMessage = document.getElementById('coupon-message');

            const originalPrice = parseFloat(totalPriceHidden.value) || 0; // Giá cũ lấy từ input ẩn

            couponInput.addEventListener('input', function() {
                const enteredCode = couponInput.value.trim();

                if (coupons && coupons.length > 0) {
                    console.log("Entered code:", enteredCode);
                    console.log("Coupons:", coupons);

                    // Duyệt qua mảng coupons và kiểm tra mã
                    const matchedCoupon = coupons.find(coupon =>
                        coupon.code === enteredCode);

                    if (matchedCoupon) {
                        const discountedPrice = (originalPrice * (100 - matchedCoupon.percentage_price)) /
                            100;

                        // Cập nhật giao diện: Giá cũ bị gạch và mờ đi, giá mới rõ ràng
                        totalPriceDisplay.innerHTML = `
                <span style="text-decoration: line-through; opacity: 0.6;">
                    ${originalPrice.toLocaleString('vi-VN')}₫
                </span>
                <span style="color: #ff4d4d; font-weight: bold;">
                    ${discountedPrice.toLocaleString('vi-VN')}₫
                </span>
                <br>
                <span style="color: green;">
                    Giảm giá: ${matchedCoupon.percentage_price}%.
                </span>
            `;
                        totalPriceHidden.value = discountedPrice; // Cập nhật giá trị mới vào input ẩn
                        couponMessage.textContent = "Áp dụng mã giảm giá thành công!";
                        couponMessage.style.color = "green";
                    } else if (enteredCode === "") {
                        couponMessage.textContent = ""; // Xóa thông báo nếu xóa mã
                        totalPriceDisplay.innerHTML = `
                <span>${originalPrice.toLocaleString('vi-VN')}₫</span>
            `; // Hiện giá cũ
                    } else {
                        // Nếu mã không khớp
                        couponMessage.textContent = "Sai mã giảm giá hoặc mã hết hạn. Vui lòng thử lại!";
                        couponMessage.style.color = "red";
                        totalPriceDisplay.innerHTML = `
                <span>${originalPrice.toLocaleString('vi-VN')}₫</span>
            `; // Hiện giá cũ
                        totalPriceHidden.value = originalPrice; // Đặt lại giá trị gốc
                    }
                } else {
                    couponMessage.textContent = "Tour này không có mã giảm!!!";
                    couponMessage.style.color = "red";
                }
            });

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy ngày khởi hành từ HTML
            const startDateStr = document.getElementById("selected-date").textContent.trim();
            const tourDuration = <?= json_encode($tour['time']) ?>; // Số ngày của tour

            if (startDateStr && tourDuration) {
                const startDate = new Date(startDateStr); // Chuyển đổi thành đối tượng Date
                const endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + tourDuration - 1); // Cộng thêm thời lượng tour

                // Hiển thị ngày kết thúc vào giao diện
                document.getElementById("selected-enddate").textContent = endDate.toISOString().split("T")[0];

                // Cập nhật vào input ẩn để gửi đi
                document.getElementById("departure-enddate").value = endDate.toISOString().split("T")[0];
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const agreePolicyCheckbox = document.getElementById('agree-policy');
            // const submitButton = document.getElementById('submit-button');
            const policyMessage = document.getElementById('policy-message');

            // Theo dõi sự kiện thay đổi của checkbox
            agreePolicyCheckbox.addEventListener('change', function() {
                if (agreePolicyCheckbox.checked) {
                    // submitButton.disabled = false; // Kích hoạt nút submit
                    policyMessage.style.display = 'none'; // Ẩn thông báo lỗi
                } else {
                    // submitButton.disabled = true; // Vô hiệu hóa nút submit
                    policyMessage.style.display = 'block'; // Hiển thị thông báo lỗi
                }
            });
        });
    </script>
    {!! NoCaptcha::renderJs() !!}
@endsection
