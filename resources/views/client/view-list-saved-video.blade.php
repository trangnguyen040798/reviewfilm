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
			<div class="col-md-3">
				<a href="{{ route('client.film.list-saved-video', ['name_cate' => $listSavedVideo[0]->name_cate, 'index' => 1]) }}" class="box-overlay">
					<img src="{{ $listSavedVideo[0]->video->image}}" alt="">
					<div class="overlay">
						<i class="fa fa-play" aria-hidden="true"></i>
						Phát Tất cả
					</div>
				</a>

				<div class="info">
					<div>
						<h3>{{ $listSavedVideo[0]->name_cate }}</h3>
					</div>
					<p>{{ count($listSavedVideo)}} video <i class="fa fa-circle" aria-hidden="true"></i> Cập nhật lần cuối vào ngày</p>
				</div>
			</div>
			<div class="col-md-9 list-saved-video">
				<ul>
					@foreach($listSavedVideo as $key => $value)
					<a href="{{ route('client.film.list-saved-video', ['name_cate' => $listSavedVideo[0]->name_cate, 'index' => $key + 1]) }}">
						<li>			
							<i class="fa fa-hand-o-right" aria-hidden="true"></i>
							<img src="{{ $value->video->image }}" alt="">
							<div>
								<p>{{ $value->video->film->name }} - tập {{ $value->video->episode }}</p>
								<p>Được tạo bởi {{ $value->video->film->user->name}}</p>
							</div>
						</li>
					</a>
					@if($key > 0)<hr>@endif
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('assets/client/css/view-list-saved-video.css')}}">
@endsection
@section('script')
@endsection