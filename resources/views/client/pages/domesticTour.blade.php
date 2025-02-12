@extends('client.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <section class="main_container collection col-md-12 tour-grid">
                <h1 class="title-head margin-top-0 text-center">Tour trong nước</h1>
                <div class="sortPagiBar tour-sortby row-filter">
                    <div class="clearfix row">
                        <div class="col-md-3 col-sm-6">
                            <aside class="aside-item filter-price" data-group="Khoảng giá">
                                <div class="aside-title">
                                    <h2 class="title-head margin-top-0"><span data-count="0" data-title="Theo mức giá">Theo
                                            mức giá</span></h2>
                                </div>
                                <div class="aside-content filter-group">
                                    <ul>

                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-duoi-2-000-000d">
                                                    <input type="checkbox" id="filter-duoi-2-000-000d"
                                                        onchange="toggleFilter(this);" data-group="Khoảng giá"
                                                        data-field="price_min" data-text="Dưới 2.000.000đ"
                                                        value="(<2000000)" data-operator="OR">
                                                    <i class="fa"></i>
                                                    Dưới 2.000.000đ
                                                </label>
                                            </span>
                                        </li>

                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-2-000-000d-4-000-000d">
                                                    <input type="checkbox" id="filter-2-000-000d-4-000-000d"
                                                        onchange="toggleFilter(this)" data-count="0" data-group="Khoảng giá"
                                                        data-field="price_min" data-text="2.000.000đ - 4.000.000đ"
                                                        value="(>=2000000 AND <=4000000)" data-operator="OR">
                                                    <i class="fa"></i>
                                                    2.000.000đ - 4.000.000đ
                                                </label>
                                            </span>
                                        </li>

                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-4-000-000d-6-000-000d">
                                                    <input type="checkbox" id="filter-4-000-000d-6-000-000d"
                                                        onchange="toggleFilter(this)" data-count="0" data-group="Khoảng giá"
                                                        data-field="price_min" data-text="4.000.000đ - 6.000.000đ"
                                                        value="(>=4000000 AND <=6000000)" data-operator="OR">
                                                    <i class="fa"></i>
                                                    4.000.000đ - 6.000.000đ
                                                </label>
                                            </span>
                                        </li>

                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-6-000-000d-8-000-000d">
                                                    <input type="checkbox" id="filter-6-000-000d-8-000-000d"
                                                        onchange="toggleFilter(this)" data-count="0" data-group="Khoảng giá"
                                                        data-field="price_min" data-text="6.000.000đ - 8.000.000đ"
                                                        value="(>=6000000 AND <=8000000)" data-operator="OR">
                                                    <i class="fa"></i>
                                                    6.000.000đ - 8.000.000đ
                                                </label>
                                            </span>
                                        </li>
                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-8-000-000d-10-000-000d">
                                                    <input type="checkbox" id="filter-8-000-000d-10-000-000d"
                                                        onchange="toggleFilter(this)" data-count="0" data-group="Khoảng giá"
                                                        data-field="price_min" data-text="8.000.000đ - 10.000.000đ"
                                                        value="(>=8000000 AND <=10000000)" data-operator="OR">
                                                    <i class="fa"></i>
                                                    8.000.000đ - 10.000.000đ
                                                </label>
                                            </span>
                                        </li>
                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-tren10-000-000d">
                                                    <input type="checkbox" id="filter-tren10-000-000d"
                                                        onchange="toggleFilter(this)" data-count="0" data-group="Khoảng giá"
                                                        data-field="price_min" data-text="Trên 10.000.000đ"
                                                        value="(>10000000)" data-operator="OR">
                                                    <i class="fa"></i>
                                                    Trên 10.000.000đ
                                                </label>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </aside>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <aside class="aside-item filter-type" data-group="Loại">
                                <div class="aside-title">
                                    <h2 class="title-head margin-top-0"><span data-count="0" data-title="Điểm đi">Điểm
                                            đi</span></h2>
                                </div>
                                <div class="aside-content filter-group">
                                    <ul>


                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-ho-chi-minh">
                                                    <input type="checkbox" id="filter-ho-chi-minh"
                                                        onchange="toggleFilter(this)" data-group="Loại"
                                                        data-field="product_type" data-text="Hồ Chí Minh"
                                                        value="(Hồ Chí Minh)" data-operator="OR">
                                                    <i class="fa"></i>
                                                    Hồ Chí Minh
                                                </label>
                                            </span>
                                        </li>

                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-sai-gon">
                                                    <input type="checkbox" id="filter-sai-gon"
                                                        onchange="toggleFilter(this)" data-group="Loại"
                                                        data-field="product_type" data-text="Sài Gòn" value="(Sài Gòn)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Sài Gòn
                                                </label>
                                            </span>
                                        </li>

                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-tp-hue">
                                                    <input type="checkbox" id="filter-tp-hue"
                                                        onchange="toggleFilter(this)" data-group="Loại"
                                                        data-field="product_type" data-text="TP. Huế" value="(TP. Huế)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    TP. Huế
                                                </label>
                                            </span>
                                        </li>


                                    </ul>
                                </div>
                            </aside>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <aside class="aside-item filter-vendor" data-group="Hãng">
                                <div class="aside-title">
                                    <h2 class="title-head margin-top-0"><span data-count="0" data-title="Điểm đến">Điểm
                                            đến</span></h2>
                                </div>
                                <div class="aside-content filter-group" data-group="Hãng">
                                    <ul>


                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-cao-bang">
                                                    <input type="checkbox" id="filter-cao-bang"
                                                        onchange="toggleFilter(this)" data-group="Hãng"
                                                        data-field="vendor" data-text="Cao Bằng" value="(Cao Bằng)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Cao Bằng
                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-da-nang">
                                                    <input type="checkbox" id="filter-da-nang"
                                                        onchange="toggleFilter(this)" data-group="Hãng"
                                                        data-field="vendor" data-text="Đà Nẵng" value="(Đà Nẵng)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Đà Nẵng
                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-ha-noi">
                                                    <input type="checkbox" id="filter-ha-noi"
                                                        onchange="toggleFilter(this)" data-group="Hãng"
                                                        data-field="vendor" data-text="Hà Nội" value="(Hà Nội)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Hà Nội
                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-ha-tien">
                                                    <input type="checkbox" id="filter-ha-tien"
                                                        onchange="toggleFilter(this)" data-group="Hãng"
                                                        data-field="vendor" data-text="Hà Tiên" value="(Hà Tiên)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Hà Tiên
                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-hai-duong">
                                                    <input type="checkbox" id="filter-hai-duong"
                                                        onchange="toggleFilter(this)" data-group="Hãng"
                                                        data-field="vendor" data-text="Hải Dương" value="(Hải Dương)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Hải Dương
                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-hue">
                                                    <input type="checkbox" id="filter-hue" onchange="toggleFilter(this)"
                                                        data-group="Hãng" data-field="vendor" data-text="Huế"
                                                        value="(Huế)" data-operator="OR">
                                                    <i class="fa"></i>
                                                    Huế
                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-mien-tay">
                                                    <input type="checkbox" id="filter-mien-tay"
                                                        onchange="toggleFilter(this)" data-group="Hãng"
                                                        data-field="vendor" data-text="Miền Tây" value="(Miền Tây)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Miền Tây
                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-nha-trang">
                                                    <input type="checkbox" id="filter-nha-trang"
                                                        onchange="toggleFilter(this)" data-group="Hãng"
                                                        data-field="vendor" data-text="Nha Trang" value="(Nha Trang)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Nha Trang
                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-ninh-thuan">
                                                    <input type="checkbox" id="filter-ninh-thuan"
                                                        onchange="toggleFilter(this)" data-group="Hãng"
                                                        data-field="vendor" data-text="Ninh Thuận" value="(Ninh Thuận)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Ninh Thuận
                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-phan-thiet">
                                                    <input type="checkbox" id="filter-phan-thiet"
                                                        onchange="toggleFilter(this)" data-group="Hãng"
                                                        data-field="vendor" data-text="Phan Thiết" value="(Phan Thiết)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Phan Thiết
                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green ">
                                            <span>
                                                <label for="filter-phu-quoc">
                                                    <input type="checkbox" id="filter-phu-quoc"
                                                        onchange="toggleFilter(this)" data-group="Hãng"
                                                        data-field="vendor" data-text="Phú Quốc" value="(Phú Quốc)"
                                                        data-operator="OR">
                                                    <i class="fa"></i>
                                                    Phú Quốc
                                                </label>
                                            </span>
                                        </li>


                                    </ul>
                                </div>
                            </aside>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <aside class="aside-item filter-tag-style-1" data-group="tag2">
                                <div class="aside-title">
                                    <h2 class="title-head margin-top-0"><span data-count="0" data-title="Đánh giá">Đánh
                                            giá</span></h2>
                                </div>
                                <div class="aside-content filter-group">
                                    <ul>




                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-1sao">
                                                    <input type="checkbox" id="filter-1sao" onchange="toggleFilter(this)"
                                                        data-group="tag2" data-field="tags" data-text="1sao"
                                                        value="(1sao)" data-operator="OR">
                                                    <i class="fa"></i>


                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-2sao">
                                                    <input type="checkbox" id="filter-2sao" onchange="toggleFilter(this)"
                                                        data-group="tag2" data-field="tags" data-text="2sao"
                                                        value="(2sao)" data-operator="OR">
                                                    <i class="fa"></i>


                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-3sao">
                                                    <input type="checkbox" id="filter-3sao" onchange="toggleFilter(this)"
                                                        data-group="tag2" data-field="tags" data-text="3sao"
                                                        value="(3sao)" data-operator="OR">
                                                    <i class="fa"></i>


                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-4sao">
                                                    <input type="checkbox" id="filter-4sao" onchange="toggleFilter(this)"
                                                        data-group="tag2" data-field="tags" data-text="4sao"
                                                        value="(4sao)" data-operator="OR">
                                                    <i class="fa"></i>


                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                </label>
                                            </span>
                                        </li>



                                        <li class="filter-item filter-item--check-box filter-item--green">
                                            <span>
                                                <label for="filter-5sao">
                                                    <input type="checkbox" id="filter-5sao" onchange="toggleFilter(this)"
                                                        data-group="tag2" data-field="tags" data-text="5sao"
                                                        value="(5sao)" data-operator="OR">
                                                    <i class="fa"></i>


                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                </label>
                                            </span>
                                        </li>


                                    </ul>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
                <div class="category-products products">


                    <section class="products-view products-view-grid">
                        <div class="row">













                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



















                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-kham-pha-cai-be-can-tho-chau-doc-ha-tien.html"
                                            title="Du lịch khám phá Cái Bè - Cần Thơ - Châu Đốc - Hà Tiên">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/bai-tam-hon-rom951e.jpg?v=1529553447977"
                                                alt="Du lịch khám phá Cái Bè - Cần Thơ - Châu Đốc - Hà Tiên">
                                        </a>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-kham-pha-cai-be-can-tho-chau-doc-ha-tien.html"
                                                title="Du lịch khám phá Cái Bè - Cần Thơ - Châu Đốc - Hà Tiên">Du lịch khám
                                                phá Cái Bè - Cần Thơ - Châu Đốc - Hà Tiên</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">3.579.000₫</span>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">


















                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>




































































































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">


















































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 2 - 7 hằng tuần" /></div> Khởi hành: Thứ 2 - 7 hằng
                                                    tuần
                                                </li>

































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="4 ngày 3 đêm" /></div> Thời gian: 4 ngày 3 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>













                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



















                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-phu-quoc-bai-sao-vinpearl-land.html"
                                            title="Du lịch Phú Quốc - Bãi Sao - Vinpearl Land">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/357803387933c6.jpg?v=1529553550187"
                                                alt="Du lịch Phú Quốc - Bãi Sao - Vinpearl Land">
                                        </a>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-phu-quoc-bai-sao-vinpearl-land.html"
                                                title="Du lịch Phú Quốc - Bãi Sao - Vinpearl Land">Du lịch Phú Quốc - Bãi
                                                Sao - Vinpearl Land</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">4.230.000₫</span>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">






























































                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng máy bay">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_3.svg?1705894518705"
                                                            alt="Di chuyển bằng máy bay" />
                                                    </li>
























































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">


















































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 4 - 6 hằng tuần" /></div> Khởi hành: Thứ 4 - 6 hằng
                                                    tuần
                                                </li>

































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="3 ngày 2 đêm" /></div> Thời gian: 3 ngày 2 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>













                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



















                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-ha-noi-lao-cai-sapa-ha-long.html"
                                            title="Du lịch Hà Nội - Lào Cai - Sapa - Hạ Long">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/1-large1b48c.jpg?v=1529553697103"
                                                alt="Du lịch Hà Nội - Lào Cai - Sapa - Hạ Long">
                                        </a>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-ha-noi-lao-cai-sapa-ha-long.html"
                                                title="Du lịch Hà Nội - Lào Cai - Sapa - Hạ Long">Du lịch Hà Nội - Lào Cai
                                                - Sapa - Hạ Long</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">7.990.000₫</span>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">






















                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>











































                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng máy bay">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_3.svg?1705894518705"
                                                            alt="Di chuyển bằng máy bay" />
                                                    </li>






















































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">




















































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Chủ nhật" /></div> Khởi hành: Chủ nhật
                                                </li>


































                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>













                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



















                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-cao-bang-ban-gioc-bac-kan-ba-be-ha-noi.html"
                                            title="Du lịch Cao Bằng - Bản Giốc - Bắc Kạn - Ba Bể - Hà Nội">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/chiem-nguon-ve-dep-cong-vien-dia-chat-cao-bang-1486f.jpg?v=1529554586100"
                                                alt="Du lịch Cao Bằng - Bản Giốc - Bắc Kạn - Ba Bể - Hà Nội">
                                        </a>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-cao-bang-ban-gioc-bac-kan-ba-be-ha-noi.html"
                                                title="Du lịch Cao Bằng - Bản Giốc - Bắc Kạn - Ba Bể - Hà Nội">Du lịch Cao
                                                Bằng - Bản Giốc - Bắc Kạn - Ba Bể - Hà Nội</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">7.929.000₫</span>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">






















                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>



















































                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng máy bay">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_3.svg?1705894518705"
                                                            alt="Di chuyển bằng máy bay" />
                                                    </li>




































































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">
































































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 4 hằng tuần" /></div> Khởi hành: Thứ 4 hằng tuần
                                                </li>









































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="4 ngày 3 đêm" /></div> Thời gian: 4 ngày 3 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>















                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



























                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-da-nang-kdl-ba-na-hoi-an-co-do-hue.html"
                                            title="Du lịch Đà Nẵng - KDL Bà Nà - Hội An - Cố Đô Huế">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/53916-131503727972c4.jpg?v=1529554090113"
                                                alt="Du lịch Đà Nẵng - KDL Bà Nà - Hội An - Cố Đô Huế">
                                        </a>

                                        <div class="sale-off">-
                                            3%
                                        </div>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-da-nang-kdl-ba-na-hoi-an-co-do-hue.html"
                                                title="Du lịch Đà Nẵng - KDL Bà Nà - Hội An - Cố Đô Huế">Du lịch Đà Nẵng -
                                                KDL Bà Nà - Hội An - Cố Đô Huế</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">6.300.000₫</span>
                                                    </div>

                                                    <div class="old-price">
                                                        <span class="price product-price-old">
                                                            6.500.000₫
                                                        </span>
                                                    </div>

                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">






















                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>



















































                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng máy bay">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_3.svg?1705894518705"
                                                            alt="Di chuyển bằng máy bay" />
                                                    </li>




































































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">
































































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 7 hằng tuần" /></div> Khởi hành: Thứ 7 hằng tuần
                                                </li>









































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="3 ngày 2 đêm" /></div> Thời gian: 3 ngày 2 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>















                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



























                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-hue-ho-truoi-da-nang-suoi-khoang-nong-nui-than-tai-kdl-ba-na.html"
                                            title="Du lịch Huế - Hồ Truồi - Đà Nẵng - Suối Khoáng Nóng Núi Thần Tài - KDL Bà Nà">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/bana-hillsc589.jpg?v=1529554384043"
                                                alt="Du lịch Huế - Hồ Truồi - Đà Nẵng - Suối Khoáng Nóng Núi Thần Tài - KDL Bà Nà">
                                        </a>

                                        <div class="sale-off">-
                                            5%
                                        </div>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-hue-ho-truoi-da-nang-suoi-khoang-nong-nui-than-tai-kdl-ba-na.html"
                                                title="Du lịch Huế - Hồ Truồi - Đà Nẵng - Suối Khoáng Nóng Núi Thần Tài - KDL Bà Nà">Du
                                                lịch Huế - Hồ Truồi - Đà Nẵng - Suối Khoáng Nóng Núi Thần Tài - KDL Bà
                                                Nà</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">5.900.000₫</span>
                                                    </div>

                                                    <div class="old-price">
                                                        <span class="price product-price-old">
                                                            6.200.000₫
                                                        </span>
                                                    </div>

                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">






















                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>



















































                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng máy bay">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_3.svg?1705894518705"
                                                            alt="Di chuyển bằng máy bay" />
                                                    </li>




































































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">
































































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 7 hằng tuần" /></div> Khởi hành: Thứ 7 hằng tuần
                                                </li>









































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="4 ngày 3 đêm" /></div> Thời gian: 4 ngày 3 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>















                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



























                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-nha-trang-hon-lao-doc-let.html"
                                            title="Du lịch Nha Trang - Hòn Lao - Dốc Lết">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/ponagar-cham-temple-nha-trang-min10994.jpg?v=1529554507043"
                                                alt="Du lịch Nha Trang - Hòn Lao - Dốc Lết">
                                        </a>

                                        <div class="sale-off">-
                                            22%
                                        </div>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-nha-trang-hon-lao-doc-let.html"
                                                title="Du lịch Nha Trang - Hòn Lao - Dốc Lết">Du lịch Nha Trang - Hòn Lao -
                                                Dốc Lết</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">3.410.000₫</span>
                                                    </div>

                                                    <div class="old-price">
                                                        <span class="price product-price-old">
                                                            4.400.000₫
                                                        </span>
                                                    </div>

                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">


















                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>











































                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng máy bay">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_3.svg?1705894518705"
                                                            alt="Di chuyển bằng máy bay" />
                                                    </li>




























































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">
















































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 5; Chủ nhật" /></div> Khởi hành: Thứ 5; Chủ nhật
                                                </li>





































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="4 ngày 3 đêm" /></div> Thời gian: 4 ngày 3 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>













                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



















                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-nha-trang-hon-lao.html" title="Du lịch Nha Trang - Hòn Lao">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/anam-resort-nha-trang-vietnam-23c70f.jpg?v=1529554176777"
                                                alt="Du lịch Nha Trang - Hòn Lao">
                                        </a>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-nha-trang-hon-lao.html"
                                                title="Du lịch Nha Trang - Hòn Lao">Du lịch Nha Trang - Hòn Lao</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">3.300.000₫</span>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">


















                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>











































                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng máy bay">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_3.svg?1705894518705"
                                                            alt="Di chuyển bằng máy bay" />
                                                    </li>




























































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">
















































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 4 hằng tuần" /></div> Khởi hành: Thứ 4 hằng tuần
                                                </li>





































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="4 ngày 3 đêm" /></div> Thời gian: 4 ngày 3 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>













                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



















                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-phan-thiet-mui-ne-cong-vien-tuong-cat.html"
                                            title="Du lịch Phan Thiết - Mũi Né - Công Viên Tượng Cát">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/vietnam-beach-viewf0a3.jpg?v=1529555091687"
                                                alt="Du lịch Phan Thiết - Mũi Né - Công Viên Tượng Cát">
                                        </a>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-phan-thiet-mui-ne-cong-vien-tuong-cat.html"
                                                title="Du lịch Phan Thiết - Mũi Né - Công Viên Tượng Cát">Du lịch Phan
                                                Thiết - Mũi Né - Công Viên Tượng Cát</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">2.130.000₫</span>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">














                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>




















































































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">


































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 2 hằng tuần" /></div> Khởi hành: Thứ 2 hằng tuần
                                                </li>





























                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="2 ngày 1 đêm" /></div> Thời gian: 2 ngày 1 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>













                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



















                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-phu-quoc-cau-ca-ngam-san-ho.html"
                                            title="Du lịch Phú Quốc Câu cá - Ngắm san hô">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/san-golf-9-loe8b9.jpg?v=1529554845807"
                                                alt="Du lịch Phú Quốc Câu cá - Ngắm san hô">
                                        </a>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-phu-quoc-cau-ca-ngam-san-ho.html"
                                                title="Du lịch Phú Quốc Câu cá - Ngắm san hô">Du lịch Phú Quốc Câu cá -
                                                Ngắm san hô</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">4.000.000₫</span>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">


















                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>

































                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng tàu thủy">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_2.svg?1705894518705"
                                                            alt="Di chuyển bằng tàu thủy" />
                                                    </li>





















                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng máy bay">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_3.svg?1705894518705"
                                                            alt="Di chuyển bằng máy bay" />
                                                    </li>








































































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">






























































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 5 hằng tuần" /></div> Khởi hành: Thứ 5 hằng tuần
                                                </li>













































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="4 ngày 3 đêm" /></div> Thời gian: 4 ngày 3 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>















                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



























                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-ninh-chu-vinh-vinh-hy.html"
                                            title="Du lịch Ninh Chữ - Vịnh Vĩnh Hy">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/cotoebaf.jpg?v=1529556178670"
                                                alt="Du lịch Ninh Chữ - Vịnh Vĩnh Hy">
                                        </a>

                                        <div class="sale-off">-
                                            26%
                                        </div>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-ninh-chu-vinh-vinh-hy.html"
                                                title="Du lịch Ninh Chữ - Vịnh Vĩnh Hy">Du lịch Ninh Chữ - Vịnh Vĩnh Hy</a>
                                        </h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">3.200.000₫</span>
                                                    </div>

                                                    <div class="old-price">
                                                        <span class="price product-price-old">
                                                            4.300.000₫
                                                        </span>
                                                    </div>

                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">














                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>




















































































                                                </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">


































































                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 6 hằng tuần" /></div> Khởi hành: Thứ 6 hằng tuần
                                                </li>





























                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="2 ngày 1 đêm" /></div> Thời gian: 2 ngày 1 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>













                            <div class="col-100 col-xs-6 col-sm-4 col-lg-3">



















                                <div class="product-box">
                                    <div class="product-thumbnail">
                                        <a href="du-lich-my-tho-can-tho-ca-mau-bac-lieu-soc-trang.html"
                                            title="Du lịch Mỹ Tho - Cần Thơ - Cà Mau - Bạc Liêu - Sóc Trăng">
                                            <img src="client/bizweb.dktcdn.net/thumb/large/100/299/077/products/vt-2-12b72.jpg?v=1529554973220"
                                                alt="Du lịch Mỹ Tho - Cần Thơ - Cà Mau - Bạc Liêu - Sóc Trăng">
                                        </a>

                                    </div>
                                    <div class="product-info a-left">
                                        <h3 class="product-name"><a class="line-clamp"
                                                href="du-lich-my-tho-can-tho-ca-mau-bac-lieu-soc-trang.html"
                                                title="Du lịch Mỹ Tho - Cần Thơ - Cà Mau - Bạc Liêu - Sóc Trăng">Du lịch Mỹ
                                                Tho - Cần Thơ - Cà Mau - Bạc Liêu - Sóc Trăng</a></h3>
                                        <div class="clearfix">
                                            <div class="box-prices">


                                                <div class="price-box clearfix">
                                                    <div class="special-price f-left">
                                                        <span class="price product-price">2.000.000₫</span>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="box-tag">
                                                <ul class="ct_course_list">



                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng Ô tô">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_1.svg?1705894518705"
                                                            alt="Di chuyển bằng Ô tô" />
                                                    </li>

                                                    <li data-toggle="tooltip" data-placement="top"
                                                        title="Di chuyển bằng tàu thủy">
                                                        <img src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_2.svg?1705894518705"
                                                            alt="Di chuyển bằng tàu thủy" />
                                                    </li </ul>
                                            </div>

                                        </div>

                                        <div class="box-date-tour">
                                            <ul class="ct_course_list">




                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_4.svg?1705894518705"
                                                            alt="Thứ 4 hằng tuần" /></div> Khởi hành: Thứ 4 hằng tuần
                                                </li>






                                                <li class="clearfix">
                                                    <div class="ulimg"><img
                                                            src="http://bizweb.dktcdn.net/100/299/077/themes/642224/assets/tag_icon_5.svg?1705894518705"
                                                            alt="4 ngày 3 đêm" /></div> Thời gian: 4 ngày 3 đêm
                                                </li>




                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="text-xs-right">

                            <nav class="text-center">
                                <ul class="pagination clearfix">

                                    <li class="page-item disabled"><a class="page-link" href="#">«</a></li>





                                    <li class="active page-item disabled"><a class="page-link" href="javascript:;">1</a>
                                    </li>




                                    <li class="page-item"><a class="page-link" onclick="doSearch(2)"
                                            href="javascript:;">2</a></li>




                                    <li class="page-item"><a class="page-link" onclick="doSearch(2)"
                                            href="javascript:;">»</a></li>

                                </ul>
                            </nav>

                        </div>

                    </section>


                </div>
            </section>
        </div>
    </div>
@endsection
