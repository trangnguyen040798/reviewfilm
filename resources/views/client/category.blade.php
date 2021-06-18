@extends('client.layouts.master')
@section('content')
<div class="general-agileits-w3l">
	<div class="w3l-medile-movies-grids">

		<!-- /movie-browse-agile -->
		
		<div class="movie-browse-agile">
			<!--/browse-agile-w3ls -->
			<div class="browse-agile-w3ls general-w3ls">
				<div class="tittle-head">
					<h4 class="latest-text">{{ $category['title'] }} </h4>
					<!---728x90--->
					<div class="container">
						<div class="agileits-single-top">
							<ol class="breadcrumb">
								<li>
									<a href="{{ route('client.index') }}">Home</a>
								</li>
								<li class="active">
									@if($type == 'film')
									Thể Loại
									@elseif($type == 'country')
									Quốc Gia
									@elseif($type == 'type')
									Hình Thức
									@endif
								</li>
							</ol>
						</div>
					</div>
				</div>
				<!---728x90--->
				<div class="container">
					<div class="col-md-3">
						<form class="filter" id="filter-btn">
							@csrf
							<input type="hidden" name="type_route" value="{{ $type }}">
							<input type="hidden" name="slug" value="{{ $slug }}">
							@if($type != 'film')
							<div class="box-filter">
								<label class="text-bold">Thể loại</label>
								<br>
								<select name="categories[]" class="form-control select-categories" multiple="multiple">
									@if(isset($cateFilms) && !empty($cateFilms))
									@foreach($cateFilms as $key => $category)
									<option value="{{ $category['id'] }}">{{ $category['title'] }}</option>
									@endforeach
									@endif
								</select>
							</div>
							@endif
							@if($type != 'type')
							<div class="box-filter">
								<label class="text-bold">Hình thức</label>
								<div class="form-filter">
									@if(isset($typeFilms) && !empty($typeFilms))
									@foreach($typeFilms as $key => $value)
									<div>
										<input type="radio" name="type" id="{{ $value }}" value="{{ $key }}">
										<label for="{{ $value }}">{{ $value }}</label>
									</div>
									@endforeach
									@endif
								</div>
							</div>
							@endif
							@if($type != 'country')
							<div class="box-filter">
								<label class="text-bold">Quốc gia</label>
								<br>
								<select name="countries[]" class="form-control select-countries" multiple="multiple">
									@if(isset($countries) && !empty($countries))
									@foreach($countries as $key => $country)
									<option value="{{ $country['id'] }}">{{ $country['title'] }}</option>
									@endforeach
									@endif
								</select>
							</div>
							@endif
							<div class="box-filter">
								<label class="text-bold">Năm phát hành</label>
								<br>
								<input type="" name="year" class="form-control" placeholder="Nhập năm phát hành">
							</div>
							<div class="box-filter form-filter">
								<div>
									<input type="radio" name="top" id="top-viewed" value="top-viewed">
									<label for="top-viewed">Xem nhiều nhất</label>
								</div>
								<div>
									<input type="radio" name="top" id="top-rating" value="top-rating">
									<label for="top-rating">Rating cao nhất</label>
								</div>
							</div>
							<button type="submit" class="btn btn-secondary">Seach</button>
						</form>
					</div>
					<div class="col-md-9">
						<div class="list-film">
							@if (isset($films) && !empty($films))
							@foreach($films as $key => $film)
							<div class="w3l-movie-gride-agile">
								<a href="{{ route('client.film.detail', [$film->id]) }}" class="hvr-shutter-out-horizontal">
									<img src="{{ $film->image }}" title="album-name" alt=" ">
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
						</div>
						{{ $films->links() }}
					</div>
				</div>
			</div>
		</div>
		<!-- //movie-browse-agile -->
		<!--body wrapper start-->
		<!--body wrapper start-->
		<div class="clearfix">
		</div>	
	</div>
	<!-- //w3l-medile-movies-grids -->
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('assets/client/css/category.css') }}">
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		let films = @json($films);
		films = films.data;
		for (var i = 0; i < films.length; i++) {
			
			setRating('.rate-', films[i].rating, i);
		}
	})
</script>
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/myjs/handlebars.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
@include('client.components.handle-bars.list-film')
<script type="text/javascript" src="{{ asset('assets/client/js/category.js') }}"></script>
@endsection