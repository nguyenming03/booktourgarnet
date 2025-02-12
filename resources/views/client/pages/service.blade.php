@extends('client.layouts.app')
@section('title')
    Cẩm Nang Du lịch
@endsection
@section('style')

 
@endsection
@section('content')
<div class="container" itemscope itemtype="http://schema.org/Blog">
	<meta itemprop="name" content="Dịch vụ tour"> 
	<meta itemprop="description" content="Chủ đề không có mô tả"> 
	<div class="row">
		<section class="right-content col-md-9 col-md-push-3">			
			<div class="box-heading">
				<h1 class="title-head">Bài viết</h1>
			</div>
			
			
			<section class="list-blogs blog-main">
				<div class="row">
					@foreach ($article as $articles)
						<div class="col-md-4 col-sm-6 col-xs-6 col-100">
							<article class="blog-item">
								<div class="blog-item-thumbnail">						
									<a href="{{ route('service.show', $articles->id) }}" class="blog-bga">
										
										
										<picture>
											{{-- <source media="(min-width: 1200px)" srcset="//bizweb.dktcdn.net/thumb/large/100/299/077/articles/hue-deohaivan.jpg?v=1520693340917">
											<source media="(min-width: 992px)" srcset="//bizweb.dktcdn.net/thumb/medium/100/299/077/articles/hue-deohaivan.jpg?v=1520693340917">
											<source media="(min-width: 767px)" srcset="//bizweb.dktcdn.net/thumb/grande/100/299/077/articles/hue-deohaivan.jpg?v=1520693340917">
											<source media="(min-width: 666px)" srcset="//bizweb.dktcdn.net/thumb/grande/100/299/077/articles/hue-deohaivan.jpg?v=1520693340917">
											<source media="(min-width: 567px)" srcset="//bizweb.dktcdn.net/thumb/large/100/299/077/articles/hue-deohaivan.jpg?v=1520693340917">
											<source media="(min-width: 480px)" srcset="//bizweb.dktcdn.net/thumb/large/100/299/077/articles/hue-deohaivan.jpg?v=1520693340917"> --}}
												<img src="{{ $articles->img_thumb ? asset('storage/' . $articles->img_thumb) : asset('path/to/default-image.jpg') }}" alt="{{ $articles->title }}" class="img-responsive center-block" />
											</picture>
										
									</a>
									<div class="articles-date">
										<span>{{ $articles->created_at->format('d-m-Y') }}</span>
										
									</div>
								</div>
								<h3 class="blog-item-name"><a href="{{ route('service.show', $articles->id) }}" title="{{$articles->title}}">{{$articles->title}}</a></h3>
								<p class="blog-item-summary margin-bottom-5">{{$articles->description}}</p>
								
								
							</article>
						</div>
					@endforeach
					<div class="col-md-12 col-sm-12 col-xs-12">
						
					</div>
				</div>
			</section>
				
			
		</section>
		<aside class="left left-content col-md-3 col-md-pull-9">
			
<aside class="aside-item collection-category blog-category">	
	<div class="heading">
		<h2 class="title-head margin-bottom-0"><span>Danh mục</span></h2>
	</div>	
	<div class="aside-content">
		<nav class="nav-category  navbar-toggleable-md" >
			<ul class="nav navbar-pills">
				
				
				<li class="nav-item "><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
				
				
				
				<li class="nav-item "><a class="nav-link" href="{{ route('introduce.index') }}">Giới thiệu</a></li>
				
				
				
				<li class="nav-item ">
					<a href="" class="nav-link">Tour theo vùng</a>
					<i class="fa fa-angle-down" ></i>
					<ul class="dropdown-menu">
						
						@foreach ($categotyTour as $categoryTours)
						<li class="dropdown-submenu nav-item">
							<a class="nav-link" href="#">{{$categoryTours->category_tour}}</a>
							<i class="fa fa-angle-down" ></i>
							<ul class="dropdown-menu">
								
								<li class="dropdown-submenu nav-item">
									<a class="nav-link" href="du-lich-quang-binh.html">Du lịch Quảng Bình</a>
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
									<a class="nav-link" href="du-lich-phan-thiet.html">Du lịch Phan Thiết</a>
								</li>
								
								<li class="dropdown-submenu nav-item">
									<a class="nav-link" href="du-lich-da-lat.html">Du lịch Đà Lạt</a>
								</li>
								
							</ul>                      
						</li>
						@endforeach
						
					</ul>
				</li>
				
				
				
				
				<li class="nav-item active"><a class="nav-link" href="{{ route('service.index') }}">Cẩm nang du lịch</a></li>
				
				
				
				{{-- <li class="nav-item "><a class="nav-link" href="{{ route('handbook.index') }}">Cẩm nang du lịch</a></li> --}}
				
				
				
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
			@foreach ($article as $articles)
				<article class="blog-item blog-item-list col-md-12">
					<a href="{{ route('service.show', $articles->id) }}" class="panel-box-media">
						<img src="{{ $articles->img_thumb ? asset('storage/' . $articles->img_thumb) : asset('path/to/default-image.jpg') }}" alt="{{ $articles->title }}" class="img-responsive center-block" />
						<div class="blogs-rights">
						<h3 class="blog-item-name"><a href="{{ route('service.show', $articles->id) }}" title="{{$articles->title}}">{{$articles->title}}</a></h3>
						<div class="post-time">{{ $articles->created_at->format('d/m/Y') }}</div>
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

@section('script')
 
@endsection


