@extends('client.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .owl-prev:hover,
        .owl-next:hover {
            opacity: 1;
            /* Khi hover sẽ hiện rõ */
        }

        .owl-prev.disabled,
        .owl-next.disabled {
            opacity: 0.3;
            /* Giảm độ mờ khi nút bị vô hiệu hóa */
            cursor: not-allowed;
            /* Thêm con trỏ chuột không cho phép khi vô hiệu hóa */
        }

        #sync1 .item,
        #sync2 .item {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #sync1 .item img,
        #sync2 .item img {
            max-width: 100%;
            height: auto;
        }

        /* Nếu bạn muốn điều chỉnh độ cao của ảnh */
        #sync1,
        #sync2 {
            margin: 0;
            padding: 0;
        }

        #sync2 .owl-item {
            width: 80px;
            /* Thu nhỏ ảnh thu nhỏ */
            margin-right: 10px;
        }

        #sync1 {
            margin-bottom: 20px;
        }

        /* styles.css hoặc file CSS chung */
        .tour-policy-content {
            max-height: 500px;
            overflow-y: auto;
        }

        .product-promotions-list-content {
            max-height: 300px;
            overflow-y: auto;
        }

        form textarea {
            width: 100%;
            height: 50px;
            resize: vertical;
        }
    </style>
    <style>
        .popup-sapo {
            position: fixed;
            bottom: 80px;
            left: 17px;
            margin: 0;
            z-index: 30;
            top: auto !important
        }

        .popup-sapo .icon {
            position: relative;
            z-index: 4;
            height: 48px;
            width: 48px;
            text-align: center;
            border-radius: 50%;
            border: 1px solid #ffffff;
            cursor: pointer;
            background: #1ba0e2;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            animation: pulse 2s infinite;
            animation: pulse 2s infinite;
            cursor: pointer
        }

        .popup-sapo .icon svg {
            fill: #ffffff;
            width: 20px;
            height: 20px;
            transition: opacity 0.35s ease-in-out, -webkit-transform 0.35s ease-in-out;
            transition: opacity 0.35s ease-in-out, transform 0.35s ease-in-out;
            transition: opacity 0.35s ease-in-out, transform 0.35s ease-in-out, -webkit-transform 0.35s ease-in-out;
            animation: iconSkew 1s infinite ease-out;
            min-height: -webkit-fill-available
        }

        .popup-sapo .content {
            background: #1ba0e2;
            color: #fff;
            padding: 20px 10px 40px;
            border-radius: 10px;
            width: 300px;
            position: absolute;
            bottom: 27px;
            left: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            -webkit-transform-origin: 100% bottom;
            transform-origin: 0 bottom;
            transform: scale(0);
            -webkit-transform: scale(0);
            -moz-transform: scale(0);
            -ms-transform: scale(0);
            -o-transform: scale(0);
            transition: -webkit-transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), -webkit-transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            -webkit-transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1)
        }

        @media (max-width: 500px) {
            .popup-sapo .content {
                width: 250px
            }
        }

        .popup-sapo .content .title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 12px;
            margin-top: 8px;
            color: #fff;
        }

        .popup-sapo .content .close-popup-sapo {
            position: absolute;
            right: 10px;
            top: 5px;
            cursor: pointer
        }

        .popup-sapo .content .close-popup-sapo svg {
            width: 15px;
            height: 15px
        }

        .popup-sapo .content .close-popup-sapo svg path {
            fill: #fff
        }

        .popup-sapo .content ul {
            margin-bottom: 20px
        }

        .popup-sapo .content ul li {
            margin-bottom: 10px
        }

        .popup-sapo .content ul li svg {
            margin-right: 10px
        }

        .popup-sapo .content ul li svg path {
            fill: #fff
        }

        .popup-sapo .content ul li a {
            color: #fff
        }

        .popup-sapo .content ul li a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .popup-sapo .content .ghichu {
            font-style: italic;
            font-size: 14px
        }

        .popup-sapo.active .content {
            -ms-transition-delay: 0.1s;
            -webkit-transition-delay: 0.15s;
            transition-delay: 0.1s;
            transform: scale(1);
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1)
        }

        .wolf-chat-plugin {
            bottom: 30px;
            z-index: 99;
            background-color: rgb(10, 124, 255);
            align-items: center;
            border-radius: 60px;
            display: flex;
            height: 44px;
            padding: 0px 16px;
            position: fixed;
            width: fit-content;
            right: 0px;
            top: auto !important;
        }
    </style>
    <style>
        .img-sm {
            width: 46px;
            height: 46px;
        }

        .panel {
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.075);
            border-radius: 0;
            border: 0;
            margin-bottom: 15px;
        }

        .panel .panel-footer,
        .panel>:last-child {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .panel .panel-heading,
        .panel>:first-child {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .panel-body {
            padding: 25px 20px;
        }


        .media-block .media-left {
            display: block;
            float: left
        }

        .media-block .media-right {
            float: right
        }

        .media-block .media-body {
            display: block;
            overflow: hidden;
            width: auto
        }

        .middle .media-left,
        .middle .media-right,
        .middle .media-body {
            vertical-align: middle
        }

        .thumbnail {
            border-radius: 0;
            border-color: #e9e9e9
        }

        .tag.tag-sm,
        .btn-group-sm>.tag {
            padding: 5px 10px;
        }

        .tag:not(.label) {
            background-color: #fff;
            padding: 6px 12px;
            border-radius: 2px;
            border: 1px solid #cdd6e1;
            font-size: 12px;
            line-height: 1.42857;
            vertical-align: middle;
            -webkit-transition: all .15s;
            transition: all .15s;
        }

        .text-muted,
        a.text-muted:hover,
        a.text-muted:focus {
            color: #acacac;
        }

        .text-sm {
            font-size: 0.9em;
        }

        .text-5x,
        .text-4x,
        .text-5x,
        .text-2x,
        .text-lg,
        .text-sm,
        .text-xs {
            line-height: 1.25;
        }

        .btn-trans {
            background-color: transparent;
            border-color: transparent;
            color: #929292;
        }

        .btn-icon {
            padding-left: 9px;
            padding-right: 9px;
        }


        .btn-group-sm>.btn,
        .btn-icon.btn-sm {
            padding: 5px 10px !important;
        }

        .mar-top {
            margin-top: 15px;
        }
    </style>
@endsection
@section('content')
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="home" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="/" title="Trang chủ">
                                <span itemprop="name">Trang chủ</span>
                                <meta itemprop="position" content="1" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>


                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="du-lich-cuba.html" title="Du lịch Cuba">
                                <span itemprop="name"><?= $tour['name'] ?></span>
                                <meta itemprop="position" content="2" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>

                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <span itemprop="name"><?= $tour['title'] ?> [<?= $tour['journeys'] ?>]</span>
                            <meta itemprop="position" content="3" />
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="product p-multiple" itemscope itemtype="http://schema.org/Product">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 details-product">
                    <div class="row margin-bottom-10 margin-bottom-20">
                        <div class="col-md-6">
                            <div id="sync1" class="owl-carousel owl-theme">
                                @foreach ($images as $img)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->name }}"
                                            style="width: 555px; height: 370px;" class="img-responsive center-block" />
                                    </div>
                                @endforeach
                            </div>

                            <div id="sync2" class="owl-carousel owl-theme">
                                @foreach ($images as $img)
                                    <div class="item">
                                        <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->name }}"
                                            style=": 70px;" class="img-responsive center-block" />
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="details-pro">
                                <h1 class="title-head"></h1>

                                <div class="sku-product hidden">
                                    SKU: <span class="variant-sku">(Đang cập nhật...)</span>
                                    <span class="hidden">Ant Du lịch</span>
                                </div>

                                <div class="journey">
                                    <span>Hành trình:</span> <?= $tour['journeys'] ?>
                                </div>

                                <ul class="ct_course_list">

                                    <li>
                                        <div class="ulimg"><img
                                                src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                alt="Di chuyển bằng Ô tô" /></div>
                                        Di chuyển bằng Ô tô
                                    </li>


                                    <li>
                                        <div class="ulimg"><img
                                                src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_2.svg?1705894518705"
                                                alt="Di chuyển bằng tàu thủy" /></div>
                                        Di chuyển bằng tàu thủy
                                    </li>
                                    <li>
                                        <div class="ulimg"><img
                                                src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_3.svg?1705894518705"
                                                alt="Di chuyển bằng máy bay" /></div>
                                        Di chuyển bằng máy bay
                                    </li>
                                    <li>
                                        <div class="ulimg"><img
                                                src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                alt="Thứ 2 - 5 hằng tuần" /></div>
                                        <span id="date-khoi-hanh">Thứ 2 - 5 hằng tuần</span>
                                    </li>

                                    <li>
                                        <div class="ulimg"><img
                                                src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                alt="10 ngày 9 đêm" /></div>
                                        <?= $tour['schedule'] ?>
                                    </li>

                                </ul>

                                <div class="product-summary product_description margin-bottom-10 margin-top-5">
                                    <div class="rte description">

                                        -<?= $tour['description'] ?>

                                    </div>
                                </div>

                                <div class="call-me-back">
                                    <ul class="row">
                                        <li class="col-md-6 col-sm-6 col-xs-6 col-100">
                                            <a href="{{ route('tour.pre-booking', ['id' => $tour->id]) }}"
                                                id="btnIconMouseScroll" title="Đặt tour" class="icon-mouse-scroll">
                                                <i class="fa fa-paper-plane" aria-hidden="true"></i> Đặt tour
                                            </a>
                                        </li>
                                        <li class="col-md-6 col-sm-6 col-xs-6 col-100">
                                            <button class="btn-callmeback" type="button" data-toggle="modal"
                                                data-target="#myModal"><i class="fa fa-phone" aria-hidden="true"></i> Gọi
                                                lại cho tôi sau</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" id="book-tour-now">
                        <div class="col-xs-12 col-sm-12 col-md-7 details-pro">
                            <div class="form-product">
                                <form>
                                    <div class="pd_tour_variants clearfix">
                                        <ul class="pd_variants_title nostyled ohidden clearfix">
                                            <li class="col-xs-4">
                                                Loại khách
                                            </li>
                                            <li class="col-xs-2 col-xss-4 noleftpadding norightpadding">
                                                Số lượng
                                            </li>
                                            <li class="col-xs-3 col-xss-4 text-right">
                                                Đơn giá
                                            </li>
                                            <li class="col-xs-3 hidden-xss text-right">
                                                Tổng giá
                                            </li>
                                        </ul>
                                        <div class="pd_variants_content clearfix">



                                            <ul class="nostyled variant_list clearfix" id="16258400">
                                                <li class="col-xs-4 variant_title">
                                                    <div class="variant_mutiple" title="Người lớn">Người lớn</div>
                                                </li>
                                                <li class="col-xs-2 col-xss-4 norightpadding noleftpadding">
                                                    <div class="quantity product-quantity clearfix">
                                                        <input type="hidden" value="16258400" name="variantId"
                                                            id="variant-0">
                                                        <button type="button" class="minus">
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <input type="number" step="1" min="1"
                                                            name="quantity" value="0" title="Số lượng"
                                                            class="qty" size="4" id="quantity-0" disabled>
                                                        <button type="button" class="plus">
                                                            <i class="fa fa-angle-up"></i>
                                                        </button>
                                                    </div>
                                                </li>
                                                <li class="col-xs-3 col-xss-4 text-right variant_price">
                                                    <?= number_format($tour['price_old'], 0, '', '.') ?>đ
                                                    <input type="hidden" name="variant_price"
                                                        value="<?= $tour['price_old'] ?>">
                                                </li>
                                                <li class="col-xs-3 hidden-xss subtotal text-right" id="subtotal">
                                                    0₫</li>
                                            </ul>






                                            <ul class="nostyled variant_list clearfix" id="16258401">
                                                <li class="col-xs-4 variant_title">
                                                    <div class="variant_mutiple" title="Trẻ em">Trẻ em</div>

                                                </li>
                                                <li class="col-xs-2 col-xss-4 norightpadding noleftpadding">
                                                    <div class="quantity product-quantity clearfix">
                                                        <input type="hidden" value="16258401" name="variantId"
                                                            id="variant-1">
                                                        <button type="button" class="minus">
                                                            <i class="fa fa-angle-down"></i>
                                                        </button>
                                                        <input type="number" step="1" min="1"
                                                            name="quantity" value="0" title="Số lượng"
                                                            class="qty" size="4" id="quantity-1" disabled>
                                                        <button type="button" value="+" class="plus">
                                                            <i class="fa fa-angle-up"></i>
                                                        </button>
                                                    </div>
                                                </li>
                                                <li class="col-xs-3 col-xss-4 text-right variant_price">
                                                    <?= number_format($tour['price_children'], 0, '', '.') ?>đ
                                                    <input type="hidden" name="variant_price"
                                                        value="<?= $tour['price_children'] ?>">
                                                </li>
                                                <li class="col-xs-3 hidden-xss subtotal text-right">0₫</li>
                                            </ul>

                                            <div class="totalPrice ohidden text-right clearfix">
                                                <span class="col-md-8 col-sm-9">
                                                    Tổng tiền
                                                </span>
                                                <strong class="col-md-4 col-sm-3"></strong>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    var length = 3;
                                            
                                                    // Lấy ngày từ server
                                                    var startDate = new Date("{{ $tour->start_date }}"); // Ngày bắt đầu từ server
                                                    var dateToday = new Date(); // Ngày hôm nay
                                            
                                                    // Đặt focus vào ô đầu tiên khi tải trang
                                                    $("#quantity-0").focus();
                                            
                                                    // Xử lý sự kiện khi bấm nút "submit"
                                                    $("#submit-table").click(function(e) {
                                                        e.preventDefault();
                                            
                                                        var toAdd = []; // Mảng chứa các sản phẩm cần thêm vào giỏ hàng
                                                        for (let i = 0; i < length; i++) {
                                                            var qty = $("#quantity-" + i).val(); // Lấy số lượng
                                                            if (qty > 0) {
                                                                toAdd.push({
                                                                    variant_id: $("#variant-" + i).val(),
                                                                    variant_date: $("#datesss").val(),
                                                                    quantity_id: qty || 0
                                                                });
                                                            }
                                                        }
                                            
                                                        // Hàm xử lý tuần tự gửi từng yêu cầu thêm vào giỏ hàng
                                                        function moveAlong() {
                                                            if (toAdd.length) {
                                                                var request = toAdd.shift(); // Lấy phần tử đầu tiên trong mảng
                                                                var data = {
                                                                    "quantity": request.quantity_id,
                                                                    "variantId": request.variant_id,
                                                                    "properties[Ngày đi]": request.variant_date
                                                                };
                                            
                                                                var params = {
                                                                    type: 'POST',
                                                                    url: '/cart/add.js',
                                                                    data: data,
                                                                    dataType: 'json',
                                                                    success: function() {
                                                                        moveAlong(); // Xử lý phần tử tiếp theo
                                                                    },
                                                                    error: function() {
                                                                        moveAlong(); // Tiếp tục dù lỗi
                                                                    }
                                                                };
                                                                $.ajax(params); // Gửi yêu cầu AJAX
                                                            } else {
                                                                document.location.href = 'cart.html'; // Chuyển hướng sau khi hoàn thành
                                                            }
                                                        }
                                            
                                                        moveAlong(); // Bắt đầu xử lý các yêu cầu
                                                    });
                                            
                                                    // Hàm chỉ cho phép chọn các ngày lớn hơn hoặc bằng hôm nay và ngày start_date
                                                    function DisablePastDays(date) {
                                                        return [date >= dateToday && date >= startDate]; // Chỉ cho phép ngày hợp lệ
                                                    }
                                            
                                                    // Cấu hình Datepicker
                                                    $(".tourmaster-datepicker").datepicker({
                                                        defaultDate: "",
                                                        changeMonth: true,
                                                        changeYear: true,
                                                        numberOfMonths: 1,
                                                        minDate: (dateToday > startDate) ? dateToday : startDate, // Lấy ngày lớn hơn trong 2 ngày
                                                        beforeShowDay: DisablePastDays // Áp dụng logic kiểm tra ngày
                                                    });
                                                });
                                            </script>
                                            
                                            <script>
                                                var tourName = <?= json_encode($tour['name']) ?>;
                                                var startDate = document.getElementById('datesss').value;
                                                



                                                // Lấy tất cả các phần tử nhóm sản phẩm
                                                const variantLists = document.querySelectorAll(".variant_list");

                                                // Phần tử hiển thị tổng tiền
                                                const totalPriceElement = document.querySelector(".totalPrice strong");


                                                // Hàm cập nhật tổng tiền
                                                function updateTotalPrice() {
                                                    let totalPrice = 0;

                                                    variantLists.forEach((variantList) => {
                                                        const quantityInput = variantList.querySelector(".qty");
                                                        const variantPriceInput = variantList.querySelector("[name='variant_price']");
                                                        const variantPrice = parseInt(variantPriceInput.value, 10);
                                                        const quantity = parseInt(quantityInput.value, 10);
                                                        totalPrice += variantPrice * quantity; // Cộng tổng tiền từ từng nhóm
                                                    });

                                                    // Hiển thị tổng tiền đã định dạng
                                                    totalPriceElement.textContent = totalPrice.toLocaleString("vi-VN") + "₫";

                                                    // Lưu thông tin vào sessionStorage
                                                    const selectedTourInfo = {
                                                        totalPrice: totalPrice,
                                                        startDate: startDate,
                                                        tourName: tourName,
                                                        quantities: Array.from(variantLists).map((variantList) => {
                                                            const quantityInput = variantList.querySelector(".qty");
                                                            const variantPriceInput = variantList.querySelector("[name='variant_price']");
                                                            return {
                                                                quantity: parseInt(quantityInput.value, 10),
                                                                price: parseInt(variantPriceInput.value, 10)
                                                            };
                                                        })
                                                    };

                                                    sessionStorage.setItem("selectedTourInfo", JSON.stringify(selectedTourInfo));
                                                }

                                                // Gắn sự kiện cho từng nhóm
                                                variantLists.forEach((variantList) => {
                                                    const minusButton = variantList.querySelector(".minus");
                                                    const plusButton = variantList.querySelector(".plus");
                                                    const quantityInput = variantList.querySelector(".qty");
                                                    const variantPriceInput = variantList.querySelector("[name='variant_price']");
                                                    const subtotalElement = variantList.querySelector(".subtotal");
                                                    const variantPrice = parseInt(variantPriceInput.value, 10);

                                                    // Hàm cập nhật tổng giá từng nhóm
                                                    function updateSubtotal(quantity) {
                                                        const total = quantity > 0 ? variantPrice * quantity : 0; // Nếu số lượng là 0 thì tổng là 0
                                                        subtotalElement.textContent = total.toLocaleString("vi-VN") + "₫"; // Cập nhật subtotal
                                                        updateTotalPrice(); // Cập nhật tổng tiền
                                                    }

                                                    // Sự kiện khi bấm nút giảm
                                                    minusButton.addEventListener("click", () => {
                                                        let currentQuantity = parseInt(quantityInput.value, 10);
                                                        if (currentQuantity > 0) {
                                                            currentQuantity -= 1;
                                                            quantityInput.value = currentQuantity;
                                                            updateSubtotal(currentQuantity); // Cập nhật subtotal khi giảm
                                                        }
                                                    });

                                                    // Sự kiện khi bấm nút tăng
                                                    plusButton.addEventListener("click", () => {
                                                        let currentQuantity = parseInt(quantityInput.value, 10);
                                                        currentQuantity += 1;
                                                        quantityInput.value = currentQuantity;
                                                        updateSubtotal(currentQuantity); // Cập nhật subtotal khi tăng
                                                    });
                                                });

                                                updateTotalPrice();
                                            </script>

                                        </div>
                                    </div>
                                    <div class="row contact_btn_group">
                                        <div class="col-md-6 col-sm-7 col-xs-6 col-100">
										<div class="line-item-property__field">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar" 
                                                    aria-hidden="true"></i></span>
												<input required class="required tourmaster-datepicker" id="datesss" 
                                                name="properties[Ngày đi]" type="text"  placeholder="Chọn Ngày đi" data-date-format="dd MM yyyy" readonly="readonly" />
											</div>
										</div>
									</div>
                                        <div class="col-md-6 col-sm-5 add-to-cart col-xs-6 col-100">
                                            <a href="{{ route('tour.pre-booking', ['id' => $tour->id]) }}">
                                                <button type="button" id="submit-table"
                                                    class="pull-right btn btn-default buynow add-to-cart button nomargin">
                                                    <i class="fa fa-paper-plane" aria-hidden="true"></i> Đặt tour
                                                </button>
                                            </a>

                                        </div>
                                        <script>
                                            function handleBookingClick(event, url) {
                                                event.preventDefault();

                                                // Lấy giá trị số lượng người lớn và trẻ em
                                                const adults = parseInt(document.getElementById('quantity-0').value, 10) || 0;
                                                const children = parseInt(document.getElementById('quantity-1').value, 10) || 0;

                                                // Kiểm tra số lượng
                                                if (adults === 0 && children === 0) {
                                                    alert('Vui lòng chọn số lượng người trước khi đặt tour!');
                                                    return;
                                                }

                                                // Lưu thông tin vào sessionStorage
                                                sessionStorage.setItem('tourBooking', JSON.stringify({
                                                    adults: adults,
                                                    children: children
                                                }));


                                                window.location.href = url;
                                            }

                                            // Gắn sự kiện click cho nút 1
                                            document.getElementById('submit-table').addEventListener('click', function(e) {
                                                handleBookingClick(e, this.closest('a').href);
                                            });

                                            // Gắn sự kiện click cho nút 2
                                            document.getElementById('btnIconMouseScroll').addEventListener('click', function(e) {
                                                handleBookingClick(e, this.href);
                                            });
                                        </script>

                                    </div>
                                    <div class="alert alert-warning alert-dismissible margin-top-20" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">×</span></button>
                                        Vui lòng liên hệ <strong><a href="tel:19006750">1900 6750</a></strong> để đặt Tour.
                                    </div>
                                    <script>
                                        if ($('.pd_tour_variants .pd_variants_content ul').length == '0') {
                                            $('.pd_tour_variants').addClass('hidden');
                                            $('.contact_btn_group').addClass('hidden');
                                            $('.alert-warning').removeClass('hidden');
                                        } else {
                                            $('.alert-warning').addClass('hidden');
                                            $.each($('.quantity'), function() {
                                                var $qty = $(this).find('input.qty')
                                                var quantity = parseInt($qty.val());
                                                var $minus = $(this).find('.minus');
                                                var $plus = $(this).find('.plus');
                                                $minus.on('click', function() {
                                                    if (quantity > 0) {
                                                        if (quantity == 1) {}
                                                        quantity -= 1;
                                                    } else {
                                                        quantity = 0;
                                                    }
                                                    $qty.val(quantity);
                                                    updatePrice()
                                                })
                                                $plus.on('click', function() {
                                                    if (quantity < 100) {
                                                        quantity += 1;
                                                    } else {
                                                        quantity = 100;
                                                    }
                                                    $qty.val(quantity);
                                                    var max = parseInt(jQuery($qty).attr('max'), 10) || 10000;
                                                    var value = parseInt(jQuery($qty).val(), 10) || 0;
                                                    if (value > max) {
                                                        alert('Chúng tôi chỉ còn ' + max + ' mặt hàng này trong kho');
                                                        jQuery($qty).val(max);
                                                    };
                                                    updatePrice();
                                                });
                                            })

                                            var updatePrice = function() {
                                                var totalPrice = 0;
                                                $.each($('.pd_variants_content ul'), function() {
                                                    var unitPrice = parseInt($(this).find('.variant_price [name="variant_price"]').val());
                                                    var qty = parseInt($(this).find('.product-quantity .qty').val());
                                                    var subTotalPrice = unitPrice * qty;
                                                    $(this).find('.subtotal').html(Bizweb.formatMoney(subTotalPrice,
                                                        "{{ 'amount_no_decimals_with_comma_separator' }}₫"));
                                                    totalPrice += subTotalPrice;
                                                })
                                                $('.totalPrice strong').html(Bizweb.formatMoney(totalPrice,
                                                    "{{ 'amount_no_decimals_with_comma_separator' }}₫"));
                                                $('.totalPrice strong').attr("data-price", totalPrice);
                                                if ($(".totalPrice strong").attr("data-price") > 0) {
                                                    $("#submit-table").removeAttr('disabled');
                                                } else {
                                                    $("#submit-table").attr('disabled', 'disabled');
                                                }
                                            }

                                            $(document).ready(function() {
                                                updatePrice();
                                            })
                                        }
                                    </script>
                                </form>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 tour-policy">


                            <div class="tour-policy-content">

                                <div class="main-project__tab--content tour-no-contentt">
                                    <div class="product-promotions-list">
                                        <h2 class="product-promotions-list-title">Chính sách Tour</h2>
                                        <div class="product-promotions-list-content">
                                            Chính sách đang được cập nhật.
                                        </div>
                                    </div>
                                </div>

                                <div class="main-project__tab--content">
                                    <div class="product-promotions-list">
                                        <h2 class="product-promotions-list-title">Chính sách Tour</h2>
                                        <div class="product-promotions-list-content">

                                            <strong>* Giá tour bao gồm:</strong><br />
                                            <?= $tour['content'] ?>
                                            <p><strong>* Giá tour không bao
                                                    gồm:&nbsp;&nbsp;&nbsp;</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                                                -&nbsp;Chi phí làm hộ chiếu, các chương trình tự chọn, nước uống, giặt ủi,
                                                điện thoại... và các chi phí cá nhân khác của khách ngoài chương
                                                trình.<br />
                                                -&nbsp;Hành lý quá cước, chi phí dời ngày và đổi chặng bay theo qui định của
                                                hàng không.<br />
                                                -&nbsp;Phí phòng đơn (dành cho khách yêu cầu ở phòng đơn).<br />
                                                -&nbsp;Tiền bồi dưỡng cho HDV&nbsp;và lái xe địa phương (8 CAD/ khách/
                                                ngày).</p>
                                            <p><strong>Điều khoản hủy tour (Thời gian hủy tour được tính cho ngày làm việc,
                                                    không tính ngày Thứ Bảy, Chủ Nhật và các ngày nghỉ Lễ).</strong><br />
                                                -&nbsp;Sau khi đặt cọc tour, nếu Qúy khách báo hủy tour Công ty chúng tôi sẽ
                                                không hoàn lại tiền cọc. Đồng thời Chúng tôi&nbsp;sẽ báo hủy hồ sơ &nbsp;của
                                                khách.<br />
                                                -&nbsp;Nếu Qúy khách báo hủy/chuyển tour, vui lòng thanh toán lệ phí
                                                hủy/chuyển tour cụ thể như sau:<br />
                                                1/ Trước ngày đi 30 - 35 ngày làm việc (không tính thứ Bảy &amp; Chủ Nhật
                                                &amp; ngày nghỉ Tết) thanh toán: 50% giá tour&nbsp;<br />
                                                2/ Trước ngày đi từ 10 - 29 ngày làm việc (không tính thứ Bảy &amp; Chủ Nhật
                                                &amp; ngày nghỉ Tết) thanh toán: 70% giá tour<br />
                                                3/ Trước ngày đi từ 02 - 09 ngày làm việc (không tính thứ Bảy &amp; Chủ Nhật
                                                &amp; ngày nghỉ Tết) thanh toán: 90% giá tour<br />
                                                4/ Hủy trước ngày đi trong vòng 24h trước ngày khởi hành (không tính thứ Bảy
                                                &amp; Chủ Nhật &amp; ngày nghỉ Tết): 100% giá tour<br />
                                                -&nbsp;Vì bất cứ lí do gì, nếu quý khách bị từ chối visa Canada, quý khách
                                                vui lòng nộp lệ phí là: 5.000.000 vnđ<br />
                                                -&nbsp;Quý khách có nhu cầu lưu trú tại Canada thêm ngoài chương trình tour
                                                vui lòng thông báo tại thời điểm đăng kí tour, đóng thêm chênh lệch tiền vé
                                                máy bay phụ trội ở lại về sau và các chặng bay nội địa theo quy định của
                                                hàng không.</p>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    .tour-no-content {
                                        display: none;
                                    }
                                </style>



                            </div>

                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9 margin-top-15 margin-bottom-10">
                            <div class="tour-tab-title">
                                Lịch trình Tour
                            </div>
                            <div class="product-tab">
                                {!! $tour->content !!}
                            </div>

                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                            <div class="right_module">

                                <div class="similar-product">
                                    <div class="right-bestsell clearfix">
                                        <h2>Tour gợi ý</h2>
                                        <div class="list-bestsell clearfix">

                                            <div class="list-bestsell-item">
                                                <div class="thumbnail-container clearfix">
                                                    <div class="product-image">
                                                        <a
                                                            href="du-lich-my-los-angeles-las-vegas-universal-studios-hollywood-2-dem-ks.html">

                                                            <img class="img-responsive"
                                                                src="{{ url('client/bizweb.dktcdn.net/thumb/small/100/299/077/products/83864b64404979-5ad0e1bdba9b284f3.jpg?v=1529553163227') }}"
                                                                alt="Du lịch Mỹ [Los Angeles - Las Vegas - Universal Studios Hollywood] [2 đêm KS 5* Bellagio, Las Vegas]" />

                                                        </a>
                                                    </div>
                                                    <div class="product-meta">
                                                        <h3><a href="du-lich-my-los-angeles-las-vegas-universal-studios-hollywood-2-dem-ks.html"
                                                                title="Du lịch Mỹ [Los Angeles - Las Vegas - Universal Studios Hollywood] [2 đêm KS 5* Bellagio, Las Vegas]">Du
                                                                lịch Mỹ [Los Angeles - Las Vegas - Universal Studios
                                                                Hollywood] [2 đêm KS 5* Bellagio, Las Vegas]</a></h3>
                                                        <div class="product-price-and-shipping">


                                                            <span class="price">49.000.000₫</span>

                                                            <span class="regular-price">54.000.000₫</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="list-bestsell-item">
                                                <div class="thumbnail-container clearfix">
                                                    <div class="product-image">
                                                        <a href="du-lich-ha-noi-lao-cai-sapa-ha-long.html">

                                                            <img class="img-responsive"
                                                                src="{{ url('client/bizweb.dktcdn.net/thumb/small/100/299/077/products/1-large1b48c.jpg?v=1529553697103') }}"
                                                                alt="Du lịch Hà Nội - Lào Cai - Sapa - Hạ Long" />

                                                        </a>
                                                    </div>
                                                    <div class="product-meta">
                                                        <h3><a href="du-lich-ha-noi-lao-cai-sapa-ha-long.html"
                                                                title="Du lịch Hà Nội - Lào Cai - Sapa - Hạ Long">Du lịch
                                                                Hà Nội - Lào Cai - Sapa - Hạ Long</a></h3>
                                                        <div class="product-price-and-shipping">
                                                            <span class="price">7.990.000₫</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-bestsell-item">
                                                <div class="thumbnail-container clearfix">
                                                    <div class="product-image">
                                                        <a href="du-lich-chau-au-phap-thuy-sy-nui-jungfrau-y.html">

                                                            <img class="img-responsive"
                                                                src="{{ url('client/bizweb.dktcdn.net/thumb/small/100/299/077/products/grand-britain-europe-tour-5-minffe2.jpg?v=1529553857067') }}"
                                                                alt="Du lịch Châu Âu Pháp - Thụy Sỹ - Núi Jungfrau - Ý" />

                                                        </a>
                                                    </div>
                                                    <div class="product-meta">
                                                        <h3><a href="du-lich-chau-au-phap-thuy-sy-nui-jungfrau-y.html"
                                                                title="Du lịch Châu Âu Pháp - Thụy Sỹ - Núi Jungfrau - Ý">Du
                                                                lịch Châu Âu Pháp - Thụy Sỹ - Núi Jungfrau - Ý</a></h3>
                                                        <div class="product-price-and-shipping">


                                                            <span class="price">85.990.000₫</span>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="list-bestsell-item">
                                                <div class="thumbnail-container clearfix">
                                                    <div class="product-image">
                                                        <a href="du-lich-phap-bi-ha-lan-hoi-hoa-tulip-keukenhof.html">

                                                            <img class="img-responsive"
                                                                src="{{ url('client/bizweb.dktcdn.net/thumb/small/100/299/077/products/0r2a5723d111.jpg?v=1529553943837') }}"
                                                                alt="Du lịch Pháp - Bỉ - Hà Lan [Hội Hoa Tulip Keukenhof]" />

                                                        </a>
                                                    </div>
                                                    <div class="product-meta">
                                                        <h3><a href="du-lich-phap-bi-ha-lan-hoi-hoa-tulip-keukenhof.html"
                                                                title="Du lịch Pháp - Bỉ - Hà Lan [Hội Hoa Tulip Keukenhof]">Du
                                                                lịch Pháp - Bỉ - Hà Lan [Hội Hoa Tulip Keukenhof]</a></h3>
                                                        <div class="product-price-and-shipping">


                                                            <span class="price">49.990.000₫</span>

                                                            <span class="regular-price">55.000.000₫</span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="list-bestsell-item">
                                                <div class="thumbnail-container clearfix">
                                                    <div class="product-image">
                                                        <a href="du-lich-da-nang-kdl-ba-na-hoi-an-co-do-hue.html">

                                                            <img class="img-responsive"
                                                                src="{{ url('client/bizweb.dktcdn.net/thumb/small/100/299/077/products/53916-131503727972c4.jpg?v=1529554090113') }}"
                                                                alt="Du lịch Đà Nẵng - KDL Bà Nà - Hội An - Cố Đô Huế" />

                                                        </a>
                                                    </div>
                                                    <div class="product-meta">
                                                        <h3><a href="du-lich-da-nang-kdl-ba-na-hoi-an-co-do-hue.html"
                                                                title="Du lịch Đà Nẵng - KDL Bà Nà - Hội An - Cố Đô Huế">Du
                                                                lịch Đà Nẵng - KDL Bà Nà - Hội An - Cố Đô Huế</a></h3>
                                                        <div class="product-price-and-shipping">


                                                            <span class="price">6.300.000₫</span>

                                                            <span class="regular-price">6.500.000₫</span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-bestsell-item">
                                                <div class="thumbnail-container clearfix">
                                                    <div class="product-image">
                                                        <a href="du-lich-nha-trang-hon-lao.html">

                                                            <img class="img-responsive"
                                                                src="{{ url('client/bizweb.dktcdn.net/thumb/small/100/299/077/products/anam-resort-nha-trang-vietnam-23c70f.jpg?v=1529554176777') }}"
                                                                alt="Du lịch Nha Trang - Hòn Lao" />

                                                        </a>
                                                    </div>
                                                    <div class="product-meta">
                                                        <h3><a href="du-lich-nha-trang-hon-lao.html"
                                                                title="Du lịch Nha Trang - Hòn Lao">Du lịch Nha Trang - Hòn
                                                                Lao</a></h3>
                                                        <div class="product-price-and-shipping">


                                                            <span class="price">3.300.000₫</span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="container bootdey">
                            <div class="col-md-12 bootstrap snippets">
                                <div class="panel">
                                    <div class="panel-body">
                                        <textarea class="form-control" rows="2" placeholder="What are you thinking?"></textarea>
                                        <div class="mar-top clearfix">
                                            <button class="btn  btn-primary pull-right" type="submit"><i
                                                    class="fa fa-pencil fa-fw"></i> Share</button>
                                            <a class="btn btn-trans btn-icon fa fa-video-camera add-tooltip"
                                                href="#"></a>
                                            <a class="btn btn-trans btn-icon fa fa-camera add-tooltip" href="#"></a>
                                            <a class="btn btn-trans btn-icon fa fa-file add-tooltip" href="#"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <div class="panel-body">

                                        <div class="media-block">
                                            <a class="media-left" href="#"><img class="img-circle img-sm"
                                                    alt="Profile Picture"
                                                    src="https://bootdey.com/img/Content/avatar/avatar1.png"></a>
                                            <div class="media-body">
                                                <div class="mar-btm">
                                                    <a href="#"
                                                        class="btn-link text-semibold media-heading box-inline">Lisa D.</a>
                                                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> -
                                                        From Mobile - 11 min ago</p>
                                                </div>
                                                <p>consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                                    laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim
                                                    veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut
                                                    aliquip ex ea commodo consequat.</p>
                                                <div class="pad-ver">
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm btn-default btn-hover-success"
                                                            href="#"><i class="fa fa-thumbs-up"></i></a>
                                                        <a class="btn btn-sm btn-default btn-hover-danger"
                                                            href="#"><i class="fa fa-thumbs-down"></i></a>
                                                    </div>
                                                    <a class="btn btn-sm btn-default btn-hover-primary"
                                                        href="#">Comment</a>
                                                </div>
                                                <hr>


                                                <div>
                                                    <div class="media-block">
                                                        <a class="media-left" href="#"><img
                                                                class="img-circle img-sm" alt="Profile Picture"
                                                                src="https://bootdey.com/img/Content/avatar/avatar2.png"></a>
                                                        <div class="media-body">
                                                            <div class="mar-btm">
                                                                <a href="#"
                                                                    class="btn-link text-semibold media-heading box-inline">Bobby
                                                                    Marz</a>
                                                                <p class="text-muted text-sm"><i
                                                                        class="fa fa-mobile fa-lg"></i> - From Mobile - 7
                                                                    min ago</p>
                                                            </div>
                                                            <p>Sed diam nonummy nibh euismod tincidunt ut laoreet dolore
                                                                magna aliquam erat volutpat. Ut wisi enim ad minim veniam,
                                                                quis nostrud exerci tation ullamcorper suscipit lobortis
                                                                nisl ut aliquip ex ea commodo consequat.</p>
                                                            <div class="pad-ver">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-sm btn-default btn-hover-success active"
                                                                        href="#"><i class="fa fa-thumbs-up"></i> You
                                                                        Like it</a>
                                                                    <a class="btn btn-sm btn-default btn-hover-danger"
                                                                        href="#"><i
                                                                            class="fa fa-thumbs-down"></i></a>
                                                                </div>
                                                                <a class="btn btn-sm btn-default btn-hover-primary"
                                                                    href="#">Comment</a>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>

                                                    <div class="media-block">
                                                        <a class="media-left" href="#"><img
                                                                class="img-circle img-sm" alt="Profile Picture"
                                                                src="https://bootdey.com/img/Content/avatar/avatar3.png">
                                                        </a>
                                                        <div class="media-body">
                                                            <div class="mar-btm">
                                                                <a href="#"
                                                                    class="btn-link text-semibold media-heading box-inline">Lucy
                                                                    Moon</a>
                                                                <p class="text-muted text-sm"><i
                                                                        class="fa fa-globe fa-lg"></i> - From Web - 2 min
                                                                    ago</p>
                                                            </div>
                                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate ?
                                                            </p>
                                                            <div class="pad-ver">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-sm btn-default btn-hover-success"
                                                                        href="#"><i class="fa fa-thumbs-up"></i></a>
                                                                    <a class="btn btn-sm btn-default btn-hover-danger"
                                                                        href="#"><i
                                                                            class="fa fa-thumbs-down"></i></a>
                                                                </div>
                                                                <a class="btn btn-sm btn-default btn-hover-primary"
                                                                    href="#">Comment</a>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="media-block pad-all">
                                            <a class="media-left" href="#"><img class="img-circle img-sm"
                                                    alt="Profile Picture"
                                                    src="https://bootdey.com/img/Content/avatar/avatar1.png"></a>
                                            <div class="media-body">
                                                <div class="mar-btm">
                                                    <a href="#"
                                                        class="btn-link text-semibold media-heading box-inline">John
                                                        Doe</a>
                                                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> -
                                                        From Mobile - 11 min ago</p>
                                                </div>
                                                <p>Lorem ipsum dolor sit amet.</p>
                                                <img class="img-responsive thumbnail"
                                                    src="https://www.bootdey.com/image/400x300" alt="Image">
                                                <div class="pad-ver">
                                                    <span class="tag tag-sm"><i class="fa fa-heart text-danger"></i> 250
                                                        Likes</span>
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm btn-default btn-hover-success"
                                                            href="#"><i class="fa fa-thumbs-up"></i></a>
                                                        <a class="btn btn-sm btn-default btn-hover-danger"
                                                            href="#"><i class="fa fa-thumbs-down"></i></a>
                                                    </div>
                                                    <a class="btn btn-sm btn-default btn-hover-primary"
                                                        href="#">Comment</a>
                                                </div>
                                                <hr>

                                                <!-- Comments -->
                                                <div>
                                                    <div class="media-block pad-all">
                                                        <a class="media-left" href="#"><img
                                                                class="img-circle img-sm" alt="Profile Picture"
                                                                src="https://bootdey.com/img/Content/avatar/avatar2.png"></a>
                                                        <div class="media-body">
                                                            <div class="mar-btm">
                                                                <a href="#"
                                                                    class="btn-link text-semibold media-heading box-inline">Maria
                                                                    Leanz</a>
                                                                <p class="text-muted text-sm"><i
                                                                        class="fa fa-globe fa-lg"></i> - From Web - 2 min
                                                                    ago</p>
                                                            </div>
                                                            <p>Duis autem vel eum iriure dolor in hendrerit in vulputate ?
                                                            </p>
                                                            <div>
                                                                <div class="btn-group">
                                                                    <a class="btn btn-sm btn-default btn-hover-success"
                                                                        href="#"><i class="fa fa-thumbs-up"></i></a>
                                                                    <a class="btn btn-sm btn-default btn-hover-danger"
                                                                        href="#"><i
                                                                            class="fa fa-thumbs-down"></i></a>
                                                                </div>
                                                                <a class="btn btn-sm btn-default btn-hover-primary"
                                                                    href="#">Comment</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{asset('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/datepicker.min6d1d.js')}}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            var sync1 = $("#sync1");
            var sync2 = $("#sync2");

            // Khởi tạo carousel cho sync1 (carousel chính)
            sync1.owlCarousel({
                items: 1, // 1 ảnh mỗi lần hiển thị
                margin: 10,
                nav: true,
                dots: false,
                loop: false, // Tắt loop ở đây để tránh quay lại ảnh đầu tiên
                autoplay: false,
                responsiveRefreshRate: 200,
            });

            // Khởi tạo carousel cho sync2 (carousel thu nhỏ)
            sync2.owlCarousel({
                items: 5, // 5 ảnh thu nhỏ
                margin: 10,
                nav: true,
                dots: false,
                loop: false, // Tắt loop cho ảnh thu nhỏ để tránh ảnh đầu tiên
                autoplay: false,
                responsiveRefreshRate: 100,
            });

            // Đồng bộ hóa khi người dùng nhấn vào ảnh thu nhỏ (sync2)
            sync2.on("click", ".item", function(e) {
                e.preventDefault(); // Ngừng hành động mặc định
                var index = $(this).index(); // Lấy chỉ số của ảnh được nhấn
                sync1.trigger("to.owl.carousel", [index,
                    300
                ]); // Di chuyển carousel chính đến ảnh tương ứng
            });

            // Đồng bộ hóa lại khi carousel sync1 thay đổi
            sync1.on("changed.owl.carousel", function(event) {
                var index = event.item.index; // Lấy chỉ số của ảnh đang hiển thị trong sync1
                sync2.find(".owl-item").removeClass("active").eq(index).addClass(
                    "active"); // Đánh dấu ảnh thu nhỏ tương ứng
            });

            // Đảm bảo rằng ảnh thu nhỏ đầu tiên sẽ được làm nổi bật khi tải trang
            sync2.find(".item").eq(0).addClass("active");
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra nếu phần tử .product-promotions-list-content tồn tại
            var commentContainer = document.querySelector('.product-promotions-list-content');
            if (commentContainer) {
                // Lắng nghe sự kiện submit của form
                var form = document.querySelector('form');
                if (form) {
                    form.addEventListener('submit', function(event) {
                        // Cuộn đến cuối container khi form được gửi
                        commentContainer.scrollTop = commentContainer.scrollHeight;
                    });
                }
            }
        });
    </script>
@endsection
