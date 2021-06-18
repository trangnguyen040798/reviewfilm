@extends('client.layouts.master')
@section('content')
<div class="faq">
	<div class="container">
		<div class="agileits-news-top">
			<ol class="breadcrumb">
				<li>
					<a href="{{ route('client.index') }}">Trang Chủ</a>
				</li>
				<li>
					<a href="{{ route('client.account.index') }}">Tài Khoản Cá Nhân</a>
				</li>
				<li class="active">{{ $film->name }} - Quản lý video ( {{ $film->type . ' - ' . $film->total_episodes }} tập video )</li>
			</ol>
		</div>
		<div class="agileinfo-news-top-grids">
			<div>
				<div class="col-sm-4 preview-video">
					
				</div>
				<div class="col-sm-8 list-video">
					<div class="item-video">
						<a href="{{ route('client.film.manage-video.create', [$film_id]) }}">
							<div class="dashed">
								<div class="child-dashed">
									<div class="create">
										<i class="fa fa-plus" aria-hidden="true"></i>
										Tạo video
									</div>
								</div>
							</div>
						</a>
					</div>
					@if(isset($videos) && !empty($videos))
					@foreach($videos as $key => $video)
					<div class="item-video" id="item-video-{{ $video->id }}">
						<div class="w3l-movie-gride-agile w3l-movie-gride-agile1">
							<div>
								<img src="{{ $video->image }}" title="album-name" class="img-responsive" alt=" ">
							</div>
							<div class="mid-1 agileits_w3layouts_mid_1_home">
								<div class="w3l-movie-text">
									<p>Tập {{ $video->episode }} 
										@if($video->complete)
										(Hoàn)
										@else
										(Chưa hoàn)
										@endif
									</p>							
								</div>
								<div class="mid-2 agile_mid_2_home">
									<button class="btn btn-secondary" id="preview-video" data-id="{{ $video->id }}" @if(!$video->complete) disabled @endif><i class="fa fa-eye" aria-hidden="true"></i>Xem</button>
									<a href="{{ route('client.film.manage-video.edit-video', [$film_id, $video->id])}}"><button class="btn btn-secondary"><i class="fa fa-pencil" aria-hidden="true"></i>
									Sửa</button></a>
									<button class="btn btn-secondary delete-video" data-id="{{ $video->id }}"><i class="fa fa-trash" aria-hidden="true"></i>Xóa</button>
								</div>
							</div>
						</div>
					</div>
					@endforeach
					{{ $videos->links() }}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('link')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<link rel="stylesheet" href="{{ asset('assets/client/css/manage-video.css') }}">
@endsection
@section('script')
@include('admin.components.handle-bars.video')
<script>
	let film_id = {{ $film_id }};
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/client/js/manage-video.js') }}"></script>
@endsection
