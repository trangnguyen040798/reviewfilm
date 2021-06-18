@extends('client.layouts.master')
@section('content')
@if(isset($firstSliders) && count($firstSliders) > 0)
<div id="slidey" style>
	<div class="slidey-row row">
		<div class="slidey-image col-md-8" style="background-image: url(&quot;{{ $firstSliders[0]->image }}&quot;)">
			<div class="slidey-overlay" style="opacity: 1; display: block;">
				<p class="slidey-overlay-title">{{ $firstSliders[0]->title }}</p>
				<p class="slidey-overlay-description">{{ $firstSliders[0]->content }}</p>
				<span class="slidey-progress" style="width: 517.882px; overflow: hidden;">
				</span>
			</div>
			<div class="slidey-controls slidey-controls-previous">
				<i class="fa fa-chevron-left">
				</i>
			</div>
			<div class="slidey-controls slidey-controls-next">
				<i class="fa fa-chevron-right">
				</i>
			</div>
		</div>
		<div class="slidey-list col-md-4">
			<ul>
				@if(isset($firstSliders) && count($firstSliders) > 0)
				@foreach($firstSliders as $key => $value)
				<li style="height: 100px;" @if($key == 0)class="slidey-active" @endif>
					<table class="slidey-list-table">
						<tbody>
							<tr>
								<td rowspan="2" class="slidey-list-thumbnail-container">
									<div class="slidey-list-thumbnail" style="background-image: url(&quot;{{ $value->image }}&quot;); width: 91px; height: 91px;">
									</div>
								</td>
								<td class="slidey-list-title">{{ $value->title }}</td>
							</tr>
							<tr>
								<td class="slidey-list-description is-truncated" style="width: 147px; height: 46px; display: block; overflow-wrap: break-word;">{{ $value->content }}</td>
							</tr>
						</tbody>
					</table>
				</li>
				@endforeach
				@endif
			</ul>
		</div>
	</div>
</div>
@endif
<div class="banner-bottom">
	<h4 class="latest-text w3_latest_text">Gợi ý cho bạn</h4>

	<div class="container">
		<div class="w3_agile_banner_bottom_grid">
			<div id="owl-demo-1" class="owl-carousel owl-theme">
				@if(isset($secondSliders) && count($secondSliders) > 0)
				@foreach($secondSliders as $key => $value)
				<div class="item">
					<div class="item">
						<div class="w3l-movie-gride-agile w3l-movie-gride-agile1">
							<a href="{{ route('client.film.detail', [$value->film->id]) }}" class="hvr-shutter-out-horizontal">
								<img src="{{ $value->film->image }}" title="album-name" class="img-responsive" alt=" ">
								<div class="w3l-action-icon">
									<i class="fa fa-play-circle" aria-hidden="true">
									</i>
								</div>
							</a>
							<div class="mid-1 agileits_w3layouts_mid_1_home">
								<div class="w3l-movie-text">
									<h6>
										<a href="{{ route('client.film.detail', [$value->film->id]) }}">{{ $value->film->name }}</a>
									</h6>							
								</div>
								<div class="mid-2 agile_mid_2_home">
									<p>{{ $value->film->year }}</p>
									<div class="block-stars">
										<ul class="d-rate-area sug-rate-{{ $key }}">
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
									</div>
									<div class="clearfix">
									</div>
								</div>
							</div>
							<div class="ribben">
								<p>QC</p>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				@endif
			</div>
		</div>			
	</div>
</div>
<div class="general">
	<h4 class="latest-text w3_latest_text">Top Phim</h4>
	<!---728x90--->
	<div class="container">
		<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
			<ul id="myTab" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Xem Nhiều Nhất</a>
				</li>
				<li role="presentation">
					<a href="#rating" id="rating-tab" role="tab" data-toggle="tab" aria-controls="rating" aria-expanded="true">Rating Cao Nhất</a>
				</li>
			</ul>
			<div id="myTabContent" class="tab-content">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
					<div class="w3_list_film">
						@if(isset($topVieweds) && ($topVieweds))
						@foreach($topVieweds as $key => $film)
						<div class="w3l-movie-gride-agile">
							<a href="{{ route('client.film.detail', [$film->id]) }}" class="hvr-shutter-out-horizontal">
								<img src="{{ $pathImage . $film->image }}" title="album-name" alt=" ">
								<div class="w3l-action-icon">
									<i class="fa fa-play-circle" aria-hidden="true">
									</i>
								</div>
							</a>
							<div class="mid-1">
								<div class="w3l-movie-text">
									<h6>
										<a href="{{ route('client.film.detail', [$film->id]) }}">{{ $film->name }}</a>
									</h6>							
								</div>
								<div class="mid-2">

									<p>{{ $film->year }}</p>
									<div class="block-stars">
										<p><i class="fa fa-eye" aria-hidden="true"></i>
											{{ $film->views }}</p>
										</div>
										<div class="clearfix">
										</div>
									</div>

								</div>
							</div>
							@endforeach
							@endif
							<div class="clearfix">
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="rating" aria-labelledby="rating-tab">
						<div class="w3_list_film">
							@if(isset($topRatings) && ($topRatings))
							@foreach($topRatings as $key => $film)
							<div class="w3l-movie-gride-agile">
								<a href="{{ route('client.film.detail', [$film->id]) }}" class="hvr-shutter-out-horizontal">
									<img src="{{ $pathImage . $film->image }}" title="album-name" alt=" ">
									<div class="w3l-action-icon">
										<i class="fa fa-play-circle" aria-hidden="true">
										</i>
									</div>
								</a>
								<div class="mid-1">
									<div class="w3l-movie-text">
										<h6>
											<a href="{{ route('client.film.detail', [$film->id]) }}">{{ $film->name }}</a>
										</h6>							
									</div>
									<div class="mid-2">

										<p>{{ $film->year }}</p>
										<div class="block-stars">
											<ul class="d-rate-area rate-{{ $key }}">
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
										</div>
										<div class="clearfix">
										</div>
									</div>

								</div>
							</div>
							@endforeach
							@endif
							<div class="clearfix">
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="latest">
		<h4 class="latest-text w3_latest_text">Mới Nhất</h4>
		<div class="container">
			<div class="w3_list_film">
				@if(isset($topLatests) && ($topLatests))
				@foreach($topLatests as $key => $film)
				<div class="w3l-movie-gride-agile">
					<a href="{{ route('client.film.detail', [$film->id]) }}" class="hvr-shutter-out-horizontal">
						<img src="{{ $pathImage . $film->image }}" title="album-name" alt=" ">
						<div class="w3l-action-icon">
							<i class="fa fa-play-circle" aria-hidden="true">
							</i>
						</div>
					</a>
					<div class="mid-1">
						<div class="w3l-movie-text">
							<h6>
								<a href="{{ route('client.film.detail', [$film->id]) }}">{{ $film->name }}</a>
							</h6>							
						</div>
						<div class="mid-2">

							<p>{{ $film->year }}</p>
							<div class="block-stars">
								<ul class="d-rate-area latest-rate-{{ $key }}">
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
							</div>
							<div class="clearfix">
							</div>
						</div>
						<div class="ribben">
							<p>Mới</p>
						</div>
					</div>
				</div>
				@endforeach
				@endif
				<div class="clearfix">
				</div>
			</div>
		</div>
	</div>
	@endsection
	@section('link')
	<link rel="stylesheet" href="{{ asset('assets/client/css/home.css') }}">
	@endsection
@section('script')
	<script>
		$(document).ready(function() {
			let topRatings = @json($topRatings);
			for (var i = 0; i < topRatings.length; i++) {
				setRating('.rate-', topRatings[i].rating, i);
			}
			let topLatests = @json($topLatests);
			for (var i = 0; i < topLatests.length; i++) {
				setRating('.latest-rate-', topLatests[i].rating, i);
			}
			let secondSliders = @json($secondSliders);
			for (var i = 0; i < secondSliders.length; i++) {
				setRating('.sug-rate-', secondSliders[i].film.rating, i);
			}
		})
	</script>
		@endsection