@extends('client.layouts.master')
@section('content')
<div class="faq">
	<div class="container">
		<div class="agileits-news-top">
			<ol class="breadcrumb">
				<li>
					<a href="{{ route('client.index') }}">Trang Chủ</a>
				</li>
				<li class="active">Tạo Phim</li>
			</ol>
		</div>
		<div class="agileinfo-news-top-grids">
			<div class="col-md-4 action-btn">
				<a href="{{ route('client.account.edit') }}"><button type="" class="btn btn-secondary">Cập nhật thông tin cá nhân</button></a>
				<button class="btn btn-secondary" type="button" id="sendEmail">Đổi mật khẩu</button>
				<form action="{{ route('client.logout' )}}" method="POST">
					@csrf
					<button type="sumbit" class="btn btn-secondary">Đăng xuất</button>
				</form>
				{{-- <div class="list-sv-title">	
					<i class="fa fa-bars" aria-hidden="true"></i> Danh Sách Phim Đã Lưu
				</div> --}}
			</div>
			<div class="col-md-8">
				@if ($errors->any())
				@foreach ($errors->all() as $error)
				<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
				{{ $error }}</div>
				@endforeach
				@endif
				<form class="m-form m-form--fit m-form--label-align-right" id="form_add" action="{{ route('client.film.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="m-portlet__body">
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Ảnh</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group input-b1'>
									<div class="file-loading">
										<input name="image" type="file" class="file" data-browse-on-zone-click="true" data-show-upload="false" accept="image/*">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Tên phim *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type='text' class="form-control" name="name" placeholder="Nhập tên" />
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Tên tiếng anh *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type='text' class="form-control" name="othername" placeholder="Nhập tên" />
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Hình thức phim *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<select class="form-control" name="type">
										{{-- {{dd($typeFilms)}} --}}
										@foreach($typeFilms as $key => $value)
										<option value="{{$key}}">{{$value}}</option>
										@endforeach
									</select>
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Quốc gia *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<select class="form-control" name="country_id">
										@foreach($countries as $key => $value)
										<option value="{{$value['id']}}">{{$value['title']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Đạo diễn </label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<select class="form-control" name="director_id">
										<option value="unknown">Unknown</option>
										@foreach($directors as $key => $value)
										<option value="{{$value['id']}}">{{$value['name']}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Diễn viên </label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<select class="form-control m-input select2-actors" name="actors[]"  multiple="multiple">
									@foreach($actors as $value)
									<option value="{{$value['id']}}">{{$value['name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Thể loại *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<select class="form-control select2-categories" name="categories[]"  multiple="multiple">
									@foreach($cateFilms as $value)
									<option value="{{$value['id']}}">{{$value['title']}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Năm phát hành *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type='text' class="form-control" name="year" placeholder="Nhập năm phát hành" />
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
						<div class="more-info">
							<div class="form-group m-form__group row">
								<label class="col-form-label col-lg-3 col-sm-12">Ngày phát hành </label>
								<div class="col-lg-9 col-md-8 col-sm-12">
									<div class='input-group date'>
										<input type="text" class="form-control" readonly="" placeholder="Select date" id="m_datepicker_2" name="release_date">
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-calendar-check-o"></i>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="more-info2">
							<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Tổng số tập phim </label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type='text' class="form-control" name="total_episodes" placeholder="Nhập tổng số tập" />
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Nội dung phim(tóm tắt) </label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<textarea name="description" id="" cols="30" rows="10"></textarea>
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
					</div>
					<div class="m-portlet__foot m-portlet__foot--fit">
						<div class="m-form__actions m-form__actions float-right">
Diễn viên *
							<button type="reset" class="btn btn-warning">Reset</button>
							<button type="submit" class="btn btn-success">Thêm</button>

						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
@endsection
@section('link')
<link rel="alternate" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="{{ asset('assets/client/css/create-film.css') }}">
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	$('input[name=release_date]').datepicker({
		format: "dd/mm/yyyy"
	});
	$(document).ready(function() {
		$('.select2-categories').select2({
			"placeholder" : "Vui lòng chọn thể loại phim"
		});
		$('.select2-actors').select2({
			"placeholder" : "Vui lòng chọn diễn viên"
		});
		$('select[name=type]').change(function() {
			if($(this).val() == {{ $odd_film_type }}) {
				$('.more-info').css({'display' : 'block'});
				$('.more-info2').css({'display' : 'none'});
				$('input[name=total_episodes]').val('1');
			} else {
				$('.more-info').css({'display' : 'none'});
				$('.more-info2').css({'display' : 'block'});
				$('input[name=total_episodes]').val('');
			}
		})
	});
</script>
@endsection