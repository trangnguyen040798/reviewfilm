@extends('client.layouts.master')
@section('content')
<div class="faq">
	<div class="container">
		<div class="agileits-news-top">
			<ol class="breadcrumb">
				<li>
					<a href="{{ route('client.index') }}">Trang Chủ</a>
				</li>
				<li class="active">Tài Khoản Cá Nhân</li>
			</ol>
		</div>
		<div class="agileinfo-news-top-grids">
			<div class="col-md-4 action-btn">
				<a href="{{ route('client.account.edit') }}"><button type="" class="btn btn-secondary">Cập nhật thông tin cá nhân</button></a>
				<form action="{{ route('client.logout' )}}" method="POST">
					@csrf
					<button type="sumbit" class="btn btn-secondary">Đăng xuất</button>
				</form>
				<div class="list-sv-title">	
					<i class="fa fa-bars" aria-hidden="true"></i> Danh Sách Phim Đã Lưu
				</div>
				<div class="listSavedVideo">
					@if(isset($listSavedVideo) && !empty($listSavedVideo))
					@foreach($listSavedVideo as $key => $list)
					<div class="box-saved-video">
						<div class="image-sv">
							<a href="{{ route('client.film.detail-video', [$list[0]->video_id]) }}?cate={{ $list[0]->name_cate }}">
								<img src="{{ $list[0]->video->image }}" title="album-name" alt=" ">
							</a>
							<a class="overlay" href="{{ route('client.film.detail-video', [$list[0]->video_id]) }}?cate={{ $list[0]->name_cate }}">
								<div class="text">
									{{ count($list) }}
									<p><i class="fa fa-play-circle" aria-hidden="true">
									</i></p>
								</div>
							</a>
						</div>
						<div class="content-cate">
							<a href="{{ route('client.film.detail-video', [$list[0]->video_id]) }}?cate={{ $list[0]->name_cate }}" class="cate_name">{{ $key }}</a>
							<div class="list">
								@foreach($list as $key1 => $value)
								@if($key1 <= 1)
								<a href="{{route('client.film.detail-video', [$value->video_id])}}?cate={{ $list[0]->name_cate }}">{{ $value->video->film->name }} - tập {{ $value->video->episode }}</a>
								<br>
								@endif
								@endforeach
								<a href="{{ route('client.film.view-list-saved-video', ['name_cate' => $list[0]->name_cate]) }}" class="see-more">Xem toàn bộ danh sách</a>
							</div>
						</div>
					</div>
					<hr>
					@endforeach
					@endif
				</div>
			</div>
			<div class="col-md-8">
				@if (session('success'))
				<div class="alert alert-info" role="alert">{{session('success')}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button></div>
				@endif
				<div class="card">
					<header class="card-header" style="background : url({{ $user['thumbnail'] }});">
						<div class="hello">
							<img src="{{ $user['image'] }}" alt="" />
							<i class="fa fa-camera" aria-hidden="true" data-target="#UploadImage" data-toggle="modal"></i>
						</div>
						<button class="btn btn-secondary" data-target="#UploadThumbnail" data-toggle="modal"><i class="fa fa-camera" aria-hidden="true"></i> Sửa ảnh bìa</button>
					</header>
					<div class="heading-box">
						<h1>{{ $user->name }}</h1>
						<h3>{{ $user->email }}</h3>
					</div>
				</div>
				<div class="list-btn">
					<button class="btn btn-secondary"> Danh sách phim của bạn</button>
				</div>
				<div class="list-film">
					<div class="w3l-movie-gride-agile">
						<a href="{{ route('client.film.create') }}">
							<div class="dashed">
								<div class="child-dashed">
									<div class="create">
										<i class="fa fa-plus" aria-hidden="true"></i>
										Tạo phim
									</div>
								</div>
							</div>
						</a>
					</div>
					@if (isset($films) && !empty($films))
					@foreach($films as $key => $film)
					<div class="w3l-movie-gride-agile">
						<div class="hvr-shutter-out-horizontal">
							<img src="{{ $film->image }}" title="album-name" alt=" ">
						</div>
						<div class="mid-1">
							<div class="w3l-movie-text">
								<h6 class="flex">
									<a href="{{ route('client.film.detail', [$film->id]) }}">{{ $film->name }}</a>
									<span>{{ $listTypes[$film->type] }} - @if ($film->type) {{ $film->total_episodes }} tập @endif</span>
								</h6>							
							</div>
							<div class="mid-2">
								<a href="{{ route('client.film.edit', [$film->id]) }}">
									<button class="btn btn-gray btn-sm">
										<i class="fa fa-pencil" aria-hidden="true"></i>
										Sửa
									</button>
								</a>
								<button class="btn btn-gray btn-sm" data-id="$film->id"><i class="fa fa-trash-o" aria-hidden="true"></i>
								Xóa</button>
								<a href="{{ route('client.film.manage-video.index', [$film->id]) }}">
									<button type="" class="btn btn-sm btn-gray">
										<i class="fa fa-plus" aria-hidden="true"></i> QL video
									</button>
								</a>
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
<div class="modal fade" id="UploadImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Đổi ảnh avatar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="file" name="image" accept="image/*" data-browse-on-zone-click="true">
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="UploadThumbnail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Đổi ảnh bìa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="file" name="thumbnail" accept="image/*" data-browse-on-zone-click="true">
			</div>
		</div>
	</div>
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('assets/client/css/category.css') }}">
<link rel="stylesheet" href="{{ asset('assets/client/css/account.css') }}">
@endsection
@section('script')
<script src="{{ asset('assets/client/js/account.js') }}"></script>
@endsection