@extends('client.layouts.app')
@section('title')
   Cẩm Nang Dịch Vụ
@endsection
@section('content')
    <div class="container article-wraper">
        <div class="row">
            <section class="right-content col-md-9 col-md-push-3">
                <article class="article-main" itemscope itemtype="http://schema.org/Article">



                    <meta itemprop="mainEntityOfPage"
                        content="/ai-bao-da-lat-chi-hop-style-mo-mong-cool-ngau-nhu-doi-ban-than-nay-van-co-ca-ro">
                    <meta itemprop="description" content="">
                    <meta itemprop="author" content="Nguyễn Chánh Bảo Trung">
                    <meta itemprop="headline"
                        content="Ai bảo Đà Lạt chỉ hợp style mơ mộng? Cool ngầu như đôi bạn thân này vẫn có cả rổ ảnh thần thái!">
                    <meta itemprop="image" content="{{ asset('storage/' . $showArticle->img_thumb) }}">
                    <meta itemprop="datePublished" content="10-03-2018">
                    <meta itemprop="dateModified" content="10-03-2018">
                    <div class="hidden" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                            <img src="client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/logo6d1d.png?1705894518705"
                                alt="Ant Du lịch" />
                            <meta itemprop="url"
                                content="https://bizweb.dktcdn.net/100/299/077/themes/642224/assets/logo.png?1705894518705">
                            <meta itemprop="width" content="200">
                            <meta itemprop="height" content="49">
                        </div>
                        <meta itemprop="name"
                            content="Ai bảo Đà Lạt chỉ hợp style mơ mộng? Cool ngầu như đôi bạn thân này vẫn có cả rổ ảnh thần thái!">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="title-head">{{ $showArticle->title }}</h1>

                            <div class="postby">
                                <span>Đăng bởi <b>{{ $showArticle->user->name }}</b> vào lúc
                                    {{ $showArticle->created_at->format('d-m-Y') }}</span>
                            </div>
                            <div class="article-details">
                                <div class="article-content">
                                    <div class="rte">
                                        {{-- @if ($showArticle->img_thumb)
									<img src="{{ asset('storage/' . $showArticle->img_thumb) }}" alt="{{ $showArticle->title }}" class="img-fluid">
								@endif --}}
                                        <div class="caption">
                                            <h2>{{ $showArticle->description }}</h2>
                                            <p>{!! $showArticle->content !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <script type="text/javascript" src="../s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a099baca270babc"></script>
                            <div class="addthis_inline_share_toolbox_uu9r"></div>
                        </div>

                    </div>
                </article>
            </section>

            <aside class="left left-content col-md-3 col-md-pull-9">

                <aside class="aside-item collection-category blog-category">
                    <div class="heading">
                        <h2 class="title-head margin-bottom-0"><span>Danh mục</span></h2>
                    </div>
                    <div class="aside-content">
                        <nav class="nav-category  navbar-toggleable-md">
                            <ul class="nav navbar-pills">


                                <li class="nav-item "><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>



                                <li class="nav-item "><a class="nav-link" href="{{ route('introduce.index') }}">Giới thiệu</a></li>



                                <li class="nav-item ">
                                    <a href="{{ route('tour.index') }}" class="nav-link">Tour theo vùng</a>
                                    <i class="fa fa-angle-down"></i>
                                    <ul class="dropdown-menu">


                                        <li class="dropdown-submenu nav-item">
                                            <a class="nav-link" href="mien-trung.html">Miền Trung</a>
                                            <i class="fa fa-angle-down"></i>
                                            <ul class="dropdown-menu">

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-quang-binh.html">Du lịch Quảng
                                                        Bình</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-hue.html">Du lịch Huế</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-da-nang.html">Du lịch Đà Nẵng</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-hoi-an.html">Du lịch Hội An</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-nha-trang.html">Du lịch Nha Trang</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-phan-thiet.html">Du lịch Phan
                                                        Thiết</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-da-lat.html">Du lịch Đà Lạt</a>
                                                </li>

                                            </ul>
                                        </li>



                                        <li class="dropdown-submenu nav-item">
                                            <a class="nav-link" href="mien-bac.html">Miền Bắc</a>
                                            <i class="fa fa-angle-down"></i>
                                            <ul class="dropdown-menu">

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-ha-noi.html">Du lịch Hà Nội</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-ha-long.html">Du lịch Hạ Long</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-sapa.html">Du lịch Sapa</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-ninh-binh.html">Du lịch Ninh
                                                        Bình</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-hai-phong.html">Du lịch Hải
                                                        Phòng</a>
                                                </li>

                                            </ul>
                                        </li>



                                        <li class="dropdown-submenu nav-item">
                                            <a class="nav-link" href="mien-nam.html">Miền Nam</a>
                                            <i class="fa fa-angle-down"></i>
                                            <ul class="dropdown-menu">

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-phu-quoc.html">Du lịch Phú Quốc</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-con-dao.html">Du lịch Côn Đảo</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-can-tho.html">Du lịch Cần Thơ</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-vung-tau.html">Du lịch Vũng Tàu</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-ben-tre.html">Du lịch Bến Tre</a>
                                                </li>

                                                <li class="dropdown-submenu nav-item">
                                                    <a class="nav-link" href="du-lich-dao-nam-du.html">Du lịch Đảo Nam
                                                        Du</a>
                                                </li>

                                            </ul>
                                        </li>


                                    </ul>
                                </li>

                                <li class="nav-item "><a class="nav-link" href="{{ route('service.index') }}">Cẩm nang du
                                        lịch</a></li>

                                <li class="nav-item "><a class="nav-link" href="{{route('contact.index')}}">Liên hệ</a></li>


                            </ul>
                        </nav>
                    </div>
                </aside>





				<div class="aside-item">
					<div class="heading">
						<h2 class="title-head">Bài viết khác</h2>
					</div>
					<div class="list-blogs">
						<div class="row">
							@foreach ($relatedArticles as $article)
								<article class="blog-item blog-item-list col-md-12">
									<a href="{{ route('service.show', $article->id) }}" class="panel-box-media">
										<img src="{{ $article->img_thumb ? asset('storage/' . $article->img_thumb) : asset('path/to/default-image.jpg') }}"
											width="70" height="70" alt="{{ $article->title }}" />
									</a>
									<div class="blogs-rights">
										<h3 class="blog-item-name">
											<a href="{{ route('service.show', $article->id) }}" title="{{ $article->title }}">
												{{ $article->title }}
											</a>
										</h3>
										<div class="post-time">{{ $article->created_at->format('d/m/Y') }}</div>
									</div>
								</article>
							@endforeach
						</div>
					</div>
				</div>
				

            </aside>

        </div>
    </div>
@endsection
