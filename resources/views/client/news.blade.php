@extends('client.layouts.master')
@section('content')
<div class="faq">
	<div class="container">
		<div class="agileits-news-top">
			<ol class="breadcrumb">
				<li>
					<a href="{{ route('client.index') }}">Trang CHủ</a>
				</li>
				<li>
					<a href="{{ route('client.news.cate') }}">Bản Tin</a>
				</li>
				<li class="active">Chi Tiết</li>
			</ol>
		</div>
		<div class="agileinfo-news-top-grids">
			<div class="col-md-8 wthree-top-news-left">
				<div class="wthree-news-left">
					<div class="wthree-news-left-img">
						{{-- <img src="{{ asset('')}}{{ config('admin.default_folder_image') }}{{ $news->image }}" alt> --}}
						<!---728x90--->
						<h4>{{ $news->title }}</h4>
						<div class="s-author">
							<p>Đăng bởi
								<a href="#">
									<i class="fa fa-user" aria-hidden="true">
									</i> Quản trị
								</a> &nbsp;&nbsp; 
								<i class="fa fa-calendar" aria-hidden="true">
								</i> {{ date("d/m/Y", strtotime($news->created_at)) }}
								<a href="#">
									<i class="fa fa-comments" aria-hidden="true">
									</i> Bình luận (<span class="count-comment"></span>)
								</a>
							</p>
						</div>
						<div id="fb-root" class=" fb_reset">
							<div style="position: absolute; top: -10000px; width: 0px; height: 0px;">
								<div>
								</div>
							</div>
						</div>
						<div class="w3-agile-news-text">
							<p>
								{!! $news->content !!}
							</p>
						</div>
					</div>
				</div>
				<div id='app'>
					<news :user="@if(\Illuminate\Support\Facades\Auth::check()) {{auth()->user()}} @else [] @endif" :news="{{ $news }}" asset="{{ asset('') }}">
					</news>
				</div>
			</div>
		</div>
		<div class="col-md-4 wthree-news-right">
			<!-- news-right-top -->
			<div class="news-right-top">
				<div class="wthree-news-right-heading">
					<h3>Bản tin mới nhất</h3>
				</div>
				<div class="wthree-news-right-top">
					<div class="news-grids-bottom">
						<div id="design" class="date">
							<div id="cycler">   
								@if(isset($latestNews) && !empty($latestNews))
								@foreach($latestNews as $key => $news)
								<div class="date-text">
									<a href="{{ route('client.news.detail', [$news->slug])}}">{{ $news->title }}
										@if(isset($news['new']) && $news['new'] == true)
										<span class="blinking" style="display: inline; opacity: 0.759909;">
											<img src="{{ asset('bower_components/bower/client/images/new.png') }}" alt>
										</span>
										@endif
									</a>
									<p>
										<i class="fa fa-clock-o">
										</i> {{ date('d-m-Y', strtotime($news->updated_at)) }}
									</p>
								</div>
								@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="news-right-bottom">
				<div class="wthree-news-right-heading">
					<h3>Bản tin hot</h3>
				</div>
				<div class="news-right-bottom-bg">
					<div class="news-grids-bottom">
						@if(isset($hotNews) && !empty($hotNews))
						@foreach($hotNews as $news)
						<div class="top-news-grid">
							<div class="top-news-grid-heading">
								<a href="{{ route('client.news.detail', [$news->slug])}}">{{ $news->title }}</a>
							</div>
							<div class="w3ls-news-t-grid top-t-grid">
								<ul>
									<li>
										<a href="#">
											<i class="fa fa-clock-o">
											</i> {{ date('d-m-Y', strtotime($news->created_at)) }}
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-eye">
											</i> {{ $news->views }}
										</a>
									</li>
								</ul>
							</div>
						</div>
						@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix">
		</div>
	</div>
	<div class="clearfix">
	</div>
</div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/app.js') }}"></script>
<script>
	function blinker() {
		$('.blinking').fadeOut(500);
		$('.blinking').fadeIn(500);
	}
	setInterval(blinker, 1000);
</script>
<script>
	function cycle($item, $cycler){
		setTimeout(cycle, 2000, $item.next(), $cycler);

		$item.slideUp(1000,function(){
			$item.appendTo($cycler).show();        
		});
	}
	cycle($('#cycler div:first'),  $('#cycler'));
</script>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('bower_components/bower/client/css/news.css') }}" type="text/css" media="all">
<link rel="stylesheet" href="{{ asset('assets/client/css/news.css') }}">
@endsection