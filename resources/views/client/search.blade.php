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
				<li class="active">Kết quả tìm kiếm</li>
			</ol>
		</div>
		<!---728x90--->
		<div class="single-page-agile-info">
			<h4 class="latest-text w3_latest_text">Kết Quả Tìm Kiếm</h4>
			@if(isset($listFilm) && !empty($listFilm))
			<div class="list-f">
				@foreach($listFilm as $key => $film)
				<div class="w3l-movie-gride-agile">
					<a href="{{ route('client.film.detail', [$film->id]) }}" class="hvr-shutter-out-horizontal">
						<img src="{{ $path_image . $film->image }}" title="album-name" alt=" ">
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
				</div>
				@endforeach
			</div>
			{{ $listFilm->links() }}
			@endif
		</div>
	</div>
</div>
@endsection
@section('link')
<style>
img {
	height: 225px;
    width: 100%;
    object-fit: cover;
}
.list-f {
	display: flex;
	flex-wrap: wrap;
}
.w3l-movie-gride-agile {
	width: 15%;
    margin-right: 2%;
}
.mid-1 {
	padding: 0 10px;
}
h4.latest-text {
	margin-left: 0;
}
</style>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		let listFilm = @json($listFilm);
		for (var i = 0; i < listFilm.length; i++) {
			setRating('.rate-', listFilm[i].rating, i);
		}
	})
</script>
@endsection