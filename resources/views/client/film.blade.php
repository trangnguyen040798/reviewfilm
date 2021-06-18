@extends('client.layouts.master')
@section('content')
<div class="single-page-agile-main">
	<div class="container">
		<!-- /w3l-medile-movies-grids -->
		<div class="agileits-single-top">
			<ol class="breadcrumb">
				<li>
					<a href="{{ route('client.index') }}">Trang chủ</a>
				</li>
				<li class="active">Chi Tiết Phim</li>
			</ol>
		</div>
		<!---728x90--->
		<div class="single-page-agile-info">
			<!-- /movie-browse-agile -->
			<div class="show-top-grids-w3lagile">
				<div class="col-sm-8 single-left">
					<div class="song">
						<div class="video-grid-single-page-agileits row">
							<div class="col-sm-6">
								<img src="{{ $film->image }}" alt class="img-responsive">
							</div>
							<div class="col-sm-6">
								<div class="film-name">
									<h2>{{ $film->name }}</h2>
									<h5>{{ $film->othername }}</h5>
								</div>
								<div class="div-item">
									<div class="film-item">
										<label for="">Tình trạng : </label>
										<p>{{ $film->complete == 0 ? 'Chưa hoàn' : 'Hoàn'}}</p>
									</div>
									<div class="film-item">
										<label for="">Năm : </label>
										<p>{{ $film->year}}</p>
									</div>
									<div class="film-item">
										<label for="">Quốc gia : </label>
										<p>{{ $film->country->title }}</p>
									</div>
									<div class="film-item">
										<label for="">Đạo diễn : </label>
										<p>
											@if ($film->director)
											<a href="{{ route('client.film.info-artist', [$film->director->id]) }}">{{ $film->director->name }}</a>
											@else
											'Unknown'
											@endif
										</p>
									</div>
									<div class="film-item">
										<label for="">Diễn viên : </label>
										<p>
											@if(!empty($film->actors))
											@foreach($film->actors as $key => $actor)
											<a href="{{ route('client.film.info-artist', [$actor->id]) }}">
												{{ $actor->name }} @if ($key < count($film->actors)-1)
												, 
												@endif
											</a>
											@endforeach
											@endif
										</p>
									</div>
									<div class="film-item">
										<label for="">Thể loại : </label>
										<p>
											@if(!empty($film->categories))
											@foreach($film->categories as $key => $category)
											<a href="{{ route('client.category.cate', ['film', $category->slug ])}}">
												{{ $category->title }} @if ($key < count($film->categories)-1)
												, 
												@endif
											</a>
											@endforeach
											@endif
										</p>
									</div>
									@if($film->release_date)
									<div class="film-item">
										<label for="">Ngày phát hành : </label>
										<p>
											{{ $film->release_date }}
										</p>
									</div>
									@endif
									<div class="film-item">
										<label for="">Tổng số tập : </label>
										<p>
											{{ $film->total_episodes }}
										</p>
									</div>
									<div class="film-item">
										<label>Đánh giá : </label>
										<ul class="d-rate-area">
											<input type="radio" id="detail-5-star" value="5" disabled/>
											<label for="detail-5-star" title="Amazing" class="fa fa-star-o">
											</label>
											<input type="radio" id="detail-4-star" value="4" disabled/>
											<label for="detail-4-star" title="Good" class="fa fa-star-o">
											</label>
											<input type="radio" id="detail-3-star" value="3" disabled/>
											<label for="detail-3-star" title="Average" class="fa fa-star-o"  aria-hidden="true">
											</label>
											<input type="radio" id="detail-2-star" value="2" disabled/>
											<label for="detail-2-star" title="Not Good" class="fa fa-star-o">
											</label>
											<input type="radio" id="detail-1-star" value="1" disabled/>
											<label for="detail-1-star" title="Bad" class="fa fa-star-o">
											</label>
										</ul>
										<p class="average-star">{{ $film->rating }}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix">
					</div>
					<h4 class="latest-text w3_latest_text">Nội dung phim</h4>
					<div class="film-summary">
						{{ $film->description ? $film->description : 'Chưa có'}}
					</div>
					@if(isset($videos) && count($videos) > 0)
					<h4 class="latest-text w3_latest_text">Danh sách video</h4>
					<div class="list_video">
						<div id="owl-demo-3" class="owl-carousel owl-theme">
							@foreach($videos as $video)
							<div class="item">
								<div class="w3l-movie-gride-agile w3l-movie-gride-agile1">
									<a href="{{ route('client.film.detail-video', [$video->id]) }}" class="hvr-shutter-out-horizontal">
										<img src="{{ $video->image }}" title="album-name" class="img-responsive" alt=" ">
										<div class="w3l-action-icon">
											<i class="fa fa-play-circle" aria-hidden="true">
											</i>
										</div>
									</a>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					@endif
					<div id='app'>
						<film :user="@if(\Illuminate\Support\Facades\Auth::check()) {{auth()->user()}} @else [] @endif" :film="{{ $film }}" asset="{{ asset('') }}">
						</film>
					</div>
				</div>
				<div class="col-md-4 single-right">
					<h3>Gợi ý cho bạn</h3>
					<div class="single-grid-right">
						@if(!empty($sugestion_films))
						@foreach($sugestion_films as $key => $film)
						<div class="single-right-grids">
							<div class="col-md-4 single-right-grid-left">
								<a href="{{ route('client.film.detail', [$film->id]) }}">
									<img src="{{ $film->image }}" alt>
								</a>
							</div>
							<div class="col-md-8 single-right-grid-right">
								<a href="{{ route('client.film.detail', [$film->id]) }}" class="title"> {{ $film->name }}</a>
								<p class="author">
									Created by <a href="#" class="author">{{ $film->user->name }}</a>
								</p>
								<p class="views">{{ $film->views }} views</p>
							</div>
							<div class="clearfix">
							</div>
						</div>
						@endforeach
						@endif
					</div>
				</div>
				<div class="clearfix">
				</div>
			</div>

		</div>
		<!-- //w3l-latest-movies-grids -->
	</div>	
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('assets/client/css/film.css') }}">
@endsection
@section('script')
<script>
	function checkRating(rating, num) {
		if ( rating < num ) {
			$('.d-rate-area').find('label[for=detail-' + num + '-star]').removeClass('fa-star-o').addClass('fa-star-half-o');
			$('.d-rate-area').find('input[value=' + num + ']').prop({"checked": true});

			return false;
		} else if (rating > num) {
			$('.d-rate-area').find('label[for=detail-' + num + '-star]').removeClass('fa-star-o').addClass('fa-star');
			$('.d-rate-area').find('input[value=' + num + ']').prop({"checked": true});
		} else {
			$('.d-rate-area').find('label[for=detail-' + num + '-star]').removeClass('fa-star-o').addClass('fa-star');
			$('.d-rate-area').find('input[value=' + num + ']').prop({"checked": true});

			return false;
		}

		return true;
	}
	function setRating() {
		let rating = $('.average-star').text();
		if (checkRating(rating, 0)) {
			if (checkRating(rating, 1)) {
				if (checkRating(rating, 2)) {
					if (checkRating(rating, 3)) {
						if (checkRating(rating, 4)) {
							if (checkRating(rating, 5)) {

							}
						}
					}
				}
			}
		}
	}
	$(document).ready(function() {
		setRating();
	});
	$("#owl-demo-3").owlCarousel({
		items:3,
		loop:false,
		margin:10,
		autoplayTimeout:3000,
		animateOut: 'slideOutDown',
		itemsDesktop : [640,4],
		itemsDesktopSmall : [414,3]

	});
</script>
<script src="{{ asset('js/app.js') }}"></script>
@endsection