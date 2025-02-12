@extends('client.layouts.app')
@section('title')
   {{$tour->name}}
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
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
                                <h1 class="title-head">{{ $tour->name }}</h1>

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
                                            <a href="{{route('favorite.add')}}">
                                                <i class="fa fa-heart"></i> Thêm vào yêu thích
                                            </a>
                                        </li>
                                        <li class="col-md-6 col-sm-6 col-xs-6 col-100">
                                            <button class="btn-callmeback" type="button" data-toggle="modal"
                                                data-target="#myModal"><i class="fa fa-phone" aria-hidden="true"></i> Gọi
                                                lại cho tôi sau888888888</button>
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

                                        </div>
                                    </div>
                                    <div class="row contact_btn_group">
                                        <div class="col-md-6 col-sm-7 col-xs-6 col-100">
                                            <div class="line-item-property__field">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"
                                                            aria-hidden="true"></i></span>
                                                    <input required class="required tourmaster-datepicker" id="datesss"
                                                        name="properties[Ngày đi]" type="text"
                                                        placeholder="Chọn Ngày đi" data-date-format="dd MM yyyy"
                                                        value="<?= $tour['start_date'] ?>" readonly="readonly" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-5 add-to-cart col-xs-6 col-100">
                                            <button type="submit" id="submit-table"
                                                class="pull-right btn btn-default buynow add-to-cart button nomargin">
                                                <i class="fa fa-paper-plane" aria-hidden="true"></i> Đặt tour
                                            </button>
                                        </div>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible margin-top-20" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">×</span></button>
                                        Vui lòng liên hệ <strong><a href="tel:19006750">1900 6750</a></strong> để đặt Tour.
                                    </div>
                                    {{-- <script>
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
                                    </script> --}}
                                </form>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 tour-policy">

                            <div class="tour-policy-content">
                                <div class="main-project__tab--content tour-no-content">
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


                                <p>{{ $tour->description }}</p>

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











                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
        $(document).ready(function() {
            var sync1 = $("#sync1");
            var sync2 = $("#sync2");


            sync1.owlCarousel({
                items: 1,
                margin: 10,
                nav: true,
                dots: false,
                loop: false
                autoplay: false,
                responsiveRefreshRate: 200,
            });


            sync2.owlCarousel({
                items: 5,
                margin: 10,
                nav: true,
                dots: false,
                loop: false,
                autoplay: false,
                responsiveRefreshRate: 100,
            });


            sync2.on("click", ".item", function(e) {
                e.preventDefault();
                var index = $(this).index()
                sync1.trigger("to.owl.carousel", [index,
                    300
                ]);
            });


            sync1.on("changed.owl.carousel", function(event) {
                var index = event.item.index
                sync2.find(".owl-item").removeClass("active").eq(index).addClass(
                    "active");
            });


            sync2.find(".item").eq(0).addClass("active");
        });
    </script>
@endsection
