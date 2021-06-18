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
				<li class="active">Cập nhật thông tin tài khoản</li>
			</ol>
		</div>
		<div class="agileinfo-news-top-grids">
			<div>
				<div class="col-sm-4 list-btn">
					<a href="{{ route('client.account.edit') }}"><button type="" class="btn btn-secondary">Cập nhật thông tin cá nhân</button></a>
					<a href=""><button class="btn btn-secondary">Đổi mật khẩu</button></a>
					<form action="{{ route('client.logout' )}}" method="POST">
						@csrf
						<button type="sumbit" class="btn btn-secondary">Đăng xuất</button>
					</form>
				</div>
				<div class="col-sm-8">
					<form id="updateAccount">
						<div class="form-group">
							<label for="">Tên tài khoản</label>
							<input type="text" name="name" class="form-control input_name" value="{{ $user->name }}">
							<div class="text-danger">
								<span class="error_name"></span>
							</div>
						</div>
						<div class="form-group">
							<label for="">Email</label>
							<input type="text" name="email" class="form-control input_email" value="{{ $user->email }}">
							<div class="text-danger">
								<span class="error_email"></span>
							</div>
						</div>
						<button type="submit" class="btn btn-secondary">Cập nhật</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('link')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link rel="stylesheet" href="{{ asset('assets/client/css/manage-video.css') }}">
<style type="text/css" media="screen">
	.text-danger {
		margin-top : 5px;
	}
</style>
@endsection
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('assets/client/js/edit-account.js') }}"></script>
@endsection
