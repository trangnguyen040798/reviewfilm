@extends('client.layouts.master')
@section('content')
<div class="faq">
	<div class="container">
		<div class="agileits-news-top">
			<ol class="breadcrumb">
				<li>
					<a href="{{ route('client.index' )}}">Trang Chủ</a>
				</li>
				<li class="active">Bản Tin</li>
			</ol>
		</div>
		<!---728x90--->
		<div class="agileinfo-news-top-grids">
			<div class="col-md-8 wthree-top-news-left">
				<div class="wthree-news-left">
					<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs" role="tablist">
							@if(isset($cateNews) && !empty($cateNews))
							@foreach($cateNews as $key => $cate)
							<li role="presentation" class="@if($key == 0)active @endif">
								<a href="#cate-{{ $cate['id']}}" id="cate-{{ $cate['id']}}-tab" role="tab" data-toggle="tab" aria-controls="cate-{{ $cate['id']}}" aria-expanded="true">{{ $cate['title'] }}</a>
							</li>
							@endforeach
							@endif
							{{-- <li role="presentation">
								<a href="#w3bsd" role="tab" id="w3bsd-tab" data-toggle="tab" aria-controls="w3bsd">Movie News</a>
							</li> --}}
						</ul>
						<div id="myTabContent" class="tab-content">
							@if(isset($cateNews) && !empty($cateNews))
							@foreach($cateNews as $key => $cate)
							<div role="tabpanel" class="tab-pane fade @if($key == 0)in active @endif" id="cate-{{ $cate['id']}}" aria-labelledby="cate-{{ $cate['id']}}-tab">
								@if(isset($news[$key]) && !empty($news[$key]))
								@foreach($news[$key] as $key1 => $value)
								@if($key1 == 0 || $key1 == 2 || $key1 == 4)
								<div class="wthree-news-top-left">
									@endif
									<div class="col-md-6 w3-agileits-news-left">
										<div class="col-sm-5 wthree-news-img">
											<a href="{{ route('client.news.detail', [$value->slug])}}">
												<img src="{{ asset('') }}{{ config('admin.default_folder_image') }}{{ $value->image }}" alt>
											</a>
										</div>
										<div class="col-sm-7 wthree-news-info">
											<h5>
												<a href="{{ route('client.news.detail', [$value->slug])}}">{{ $value->title }}</a>
											</h5>
											<p>{!! \Illuminate\Support\Str::limit($value->content, 100, $end='...') !!}</p>
											<ul>
												<li>
													<i class="fa fa-clock-o" aria-hidden="true">
													</i>{{ date("d/m/Y", strtotime($value->created_at)) }}
												</li>
												<li>
													<i class="fa fa-eye" aria-hidden="true">
													</i> {{ $value->views }}
												</li>
											</ul>
										</div>
									</div>
									@if($key1 == 1 || $key1 == 3 || $key1 == 5 || ($key1 == 0 && count($news[$key]) == 1))
									<div class="clearfix">
									</div>
								</div>
								@endif
								@endforeach
								@endif
								<div class="clearfix">
								</div>
								{{ $news[$key]->links() }}
							</div>
							@endforeach
							@endif
						</div>
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
											</i> {{ date('d-m-Y', strtotime($news->updated_at)) }}</p>
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
		</div>
	</div>
	@endsection
	@section('script')
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