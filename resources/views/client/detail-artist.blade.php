@extends('client.layouts.master')
@section('content')
<div class="single-page-agile-main">
	<div class="container">
		<!-- /w3l-medile-movies-grids -->
		<div class="agileits-single-top">
			<ol class="breadcrumb">
				<li>
					<a href="{{ route('client.index') }}">Trang Chủ</a>
				</li>
				<li class="active">Thông Tin Nghệ Sĩ</li>
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
								<img src="{{ $artist->image }}" alt class="img-responsive">
							</div>
							<div class="col-sm-6">
								<div class="artist-name">
									<h2>{{ $artist->name }}</h2>
								</div>
								<div class="div-item">
									<div class="artist-item">
										<label for="">Nghề nghiệp : </label>
										<p>{{ $artist->occupation ? $artist->occupation : 'chưa có' }}</p>
									</div>
									<div class="artist-item">
										<label for="">Ngày sinh : </label>
										<p>{{ $artist->birthday ? $artist->birthday : 'Chưa có'}}</p>
									</div>
									<div class="artist-item">
										<label for="">Quốc gia : </label>
										<p>{{ $artist->country ? $artist->country->title : 'Chưa có' }}</p>
									</div>
									<div class="artist-item">
										<label for="">Chiều cao : </label>
										<p>
											{{ $artist->height ? $artist->height : 'Chưa có'}}
										</p>
									</div>
									<div class="artist-item">
										<label for="">Cân nặng : </label>
										<p>
											{{ $artist->weight ? $artist->height : 'Chưa có'}}
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix">
					</div>
					<h4 class="latest-text w3_latest_text">Tiểu Sử</h4>
					<div class="artist-summary">
						{{ $artist->story ? $artist->story : 'Chưa có'}}
					</div>
					<h4 class="latest-text w3_latest_text">Danh sách phim</h4>
					<div class="list_video">
						<div id="owl-demo-3" class="owl-carousel owl-theme">
							@foreach($artist['films'] as $film)
							<div class="item">
								<div class="w3l-movie-gride-agile w3l-movie-gride-agile1">
									<a href="{{ route('client.film.detail', [$film->id]) }}" class="hvr-shutter-out-horizontal">
										<img src="{{ $film->image }}" title="album-name" class="img-responsive" alt=" ">
										<div class="w3l-action-icon">
											<i class="fa fa-play-circle" aria-hidden="true">
											</i>
										</div>
									</a>
									<div class="mid-1 agileits_w3layouts_mid_1_home">
										<div class="w3l-movie-text">
											<h6>
												<a href="{{ route('client.film.detail', [$film->id]) }}">{{ $film->name }}
												</a>
											</h6>							
										</div>
										<div class="mid-2 agile_mid_2_home">
											<p>{{ $film->year }}</p>
											<div class="block-stars">
												<ul class="w3l-ratings">
													<li>
														<a href="#">
															<i class="fa fa-star" aria-hidden="true">
															</i>
														</a>
													</li>
													<li>
														<a href="#">
															<i class="fa fa-star" aria-hidden="true">
															</i>
														</a>
													</li>
													<li>
														<a href="#">
															<i class="fa fa-star" aria-hidden="true">
															</i>
														</a>
													</li>
													<li>
														<a href="#">
															<i class="fa fa-star" aria-hidden="true">
															</i>
														</a>
													</li>
													<li>
														<a href="#">
															<i class="fa fa-star-half-o" aria-hidden="true">
															</i>
														</a>
													</li>
												</ul>
											</div>
											<div class="clearfix">
											</div>
										</div>
									</div>
									<div class="ribben">
										<p>NEW</p>
									</div>
								</div>
							</div>
							@endforeach
						</div>
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
<link rel="stylesheet" href="{{ asset('assets/client/css/detail-artist.css') }}">
@endsection
@section('script')
<script>
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
@endsection