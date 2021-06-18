@extends('client.layouts.master')
@section('content')
<div class="faq">
	<div class="container">
		<div class="agileits-news-top">
			<ol class="breadcrumb">
				<li>
					<a href="{{ route('client.index') }}">Trang Chủ</a>
				</li>
				<li class="active">Danh Sách Video Đã Lưu</li>
			</ol>
		</div>
		<div class="agileinfo-news-top-grids">
			<div class="vid-main-wrapper clearfix">
				<div class="vid-container">
					<video controls autoplay="">
						<source src="{{ $listSavedVideo[$index-1]->video->link }}" type="" media="">
						</video>
						<div class="info-video">
							<div class="first-line">
								<div>
									<h3>{{ $listSavedVideo[$index-1]->video->film->name }} @if(!isset($video->is_odd) || !$video->is_odd) - Tập {{ $listSavedVideo[$index-1]->video->episode }} @endif</h3>
								</div>
								<div>
									<span class="saveVideo" data-toggle="modal" data-target="#SavedVideo">
										<i class="fa fa-plus" aria-hidden="true"></i>
										<i class="fa fa-bars" aria-hidden="true"></i>
										LƯU
									</span>
								</div>
							</div>
							<p>{{ $listSavedVideo[$index-1]->video->views }} <span>lượt xem</span></p>
						</div>
						<div>
							<p>Comment</p>
						</div>
					</div>
					<div class="vid-list-container">
						<ul id="vid-list">
							@if(isset($listSavedVideo) && !empty($listSavedVideo))
							@foreach($listSavedVideo as $key => $value)
							<li>
								{{-- {{dd()}} --}}
								@if($key == $index-1)
								<a href="{{ route('client.film.list-saved-video', ['name_cate' => $value->name_cate, 'index' => $key + 1]) }}" class="active">
									<i class="fa fa-play" aria-hidden="true"></i>
									<img src="{{ $value->video->image }}" alt="">
									<div class="desc">
										<p>{{ $value->video->film->name }}</p>
										<p>Tập {{ $value->video->episode }}</p>
										<p>Lượt xem {{ $value->video->views }}</p>
									</div>
								</a>
								@else 
								<a href="{{ route('client.film.list-saved-video', ['name_cate' => $value->name_cate, 'index' => $key + 1]) }}">
									<i></i>
									<img src="{{ $value->video->image }}" alt="">
									<div class="desc">
										<p>{{ $value->video->film->name }}</p>
										<p>Tập {{ $value->video->episode }}</p>
										<p>Lượt xem {{ $value->video->views }}</p>
									</div>
								</a>
								@endif
							</li>
							@endforeach
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="SavedVideo" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<h3>Lưu vào ...</h3>
				<hr>
				@if(isset($listNameCateSV) && !empty($listNameCateSV))
				<div class="box-checkbox">
					@foreach($listNameCateSV as $key => $value)
					<div class="form-group">
						<input type="checkbox" name="name_cate" id="checkbox-{{ $key }}" value="{{ $value->name_cate }}" @if(isset($value['ischecked']) && $value['ischecked']) checked @endif>
						<label for="checkbox-{{ $key }}">{{ $value->name_cate }}</label>
					</div>
					@endforeach
				</div>
				@endif
				<hr>
				<form id="saved-video-form">
					<input type="hidden" name="video_id" value="{{ $listSavedVideo[$index-1]->video_id }}">
					<div class="form-group box-add-name">
						<input type="text" name="name_cate" value="" placeholder="Nhập tên danh sách" class="form-control">
						<p class="error_name_cate text-danger"></p>
					</div>
				</form>
				<p class="add-name">
					<i class="fa fa-plus" aria-hidden="true"></i>
					<span>Tạo danh sách lưu video mới</span>
				</p>
			</div>
		</div>
	</div>
	@endsection
	@section('link')
	<link rel="stylesheet" href="{{ asset('assets/client/css/list-video.css') }}">
	@endsection
	@section('script')
	<script>
		let video_id = {{ $listSavedVideo[$index-1]->video_id }};
	</script>
	<script src="{{ asset('assets/client/js/list-video.js') }}"></script>
	@endsection