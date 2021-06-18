@extends('client.layouts.master')
@section('content')
<div class="faq">
	<div class="container">
		<div class="agileits-news-top">
			<ol class="breadcrumb">
				<li>
					<a href="{{ route('client.index') }}">Trang Chủ</a>
				</li>
				<li class="active">Danh Sách Video</li>
			</ol>
		</div>
		<div class="agileinfo-news-top-grids">
			<div class="vid-main-wrapper clearfix">
				<div class="vid-container">
					<video controls autoplay>
						<source src="{{ $video->link }}" type="" media="">
						</video>
						<div class="info-video">
							<div class="first-line">
								<div>
									<h3>{{ $video->film->name }} @if(!isset($video->is_odd) || !$video->is_odd) - Tập {{ $video->episode }} @endif</h3>
								</div>
								<div>
									<span class="btnShare">
										<i class="fa fa-share" aria-hidden="true"></i>
										CHIA SẺ
										<div class="fb-share-button" data-href="{{ $video->link }}" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">FaceBook</a></div>
									</span>	
										<span class="saveVideo" data-toggle="modal" data-target="#SavedVideo">
											<i class="fa fa-plus" aria-hidden="true"></i>
											<i class="fa fa-bars" aria-hidden="true"></i>
											LƯU
										</span>
									</div>
								</div>
								<p>{{ $video->views }} <span>lượt xem</span></p>
							</div>
							<hr>
							<div class="creator">
								<img src="{{ asset('') . config('admin.default_folder_image') . $video->film->user->image}}" alt="">
								<div class="info">
									<h4>{{ $video->film->user->name }}</h4>
									<p>{{ $video->film->name }} - tập {{ $video->episode }}</p>
								</div>
							</div>
							<hr>
							<div id='app'>
								<example :user="@if(\Illuminate\Support\Facades\Auth::check()) {{auth()->user()}} @else [] @endif" :video="{{ $video }}">
								</div>
							</div>
							<div class="vid-list-container">
								<ul id="vid-list">
									@if(isset($listVideo) && !empty($listVideo))
									@foreach($listVideo as $key => $value)
									<li>
										@if($value->id === $video->id)
										<a href="{{ route('client.film.detail-video', [$value->id]) }}" class="active">
											<i class="fa fa-play" aria-hidden="true"></i>
											<img src="{{ $value->image }}" alt="">
											<div class="desc">
												<p>{{ $value->film->name }}</p>
												<p>Tập {{ $value->episode }}</p>
												<p>Lượt xem {{ $value->views }}</p>
											</div>
										</a>
										@else 
										<a href="{{ route('client.film.detail-video', [$value->id]) }}">
											<i></i>
											<img src="{{ $value->image }}" alt="">
											<div class="desc">
												<p>{{ $value->film->name }}</p>
												<p>Tập {{ $value->episode }}</p>
												<p>Lượt xem {{ $value->views }}</p>
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
							<input type="hidden" name="video_id" value="{{ $video->id }}">
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
			<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0&appId=295517044707953&autoLogAppEvents=1" nonce="Ni22gjZd"></script>
				<script>
				window.Laravel = {!! json_encode([
					'csrfToken' => csrf_token(),
					]) !!};
				let video_id = {{ $video->id }};

			</script>
			<script src="{{ mix('js/app.js') }}"></script>
			<script src="{{ asset('assets/client/js/list-video.js') }}"></script>
			@endsection