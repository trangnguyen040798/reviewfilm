@extends('admin.layouts.master')
@section('title')
Quản lý slide
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	@include('admin.components.sub-header', ['title' => 'Quản lý slide'])
	<div class="m-content m-portlet">
		<button class="btn btn-danger multi-delete">
			<i class="fa fa-trash-o"></i> Xóa <span class="count-delete"></span>
		</button>
		<button class="btn m-btn m-btn--gradient-from-focus m-btn--gradient-to-danger" data-target="#AddItem" data-toggle="modal" id="addManageSlider"><i class="fa fa-plus"></i> Thêm mới</button>
		<h4>Danh sách banner slide</h4>
		@include('admin.components.table.table-1', ['titles' => array("Ảnh", "Loại", "Tiêu đề", "Nội dung"), 'data' => $data1, 'buttons' => array('show-film', 'edit', 'delete'), 'key' => 'manage-slider-1'])
		<h4 style="margin-top: 30px;margin-bottom: 20px;">Danh sách gợi ý phim</h4>
		<button class="btn btn-danger multi-delete">
			<i class="fa fa-trash-o"></i> Xóa <span class="count-delete"></span>
		</button>
		@include('admin.components.table.table-1', ['titles' => array("Loại", "Tên Phim", "Người tạo phim"), 'data' => $data2, 'buttons' => array('show-film', 'edit', 'delete'), 'key' => 'manage-slider-2'])
	</div>
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('assets/admin/css/manage-slider.css') }}">
@endsection
@section('modal')
<div class="modal fade" id="AddItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Thêm thông tin</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="m-form m-form--fit m-form--label-align-right" id="form_add">
					<div class="m-portlet__body">
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Slider *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<select class="form-control m-input" name="tag">
									@if (isset($listSliders) && !empty($listSliders))
									@foreach($listSliders as $key => $value)
									<option value="{{ $key }}">{{ $value }}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>
					</div>
					<div class="slideFType">
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Ảnh</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group input-b1'>
									<input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true" data-show-upload="false" accept="image/*">
								</div>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Tiêu đề</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type="text" name="title" placeholder="Nhập tiêu đề" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Nội dung</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<textarea name="content" class="form-control" placeholder="Nhập nội dung" rows="3"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="m-portlet__foot m-portlet__foot--fit">
						<div class="m-form__actions m-form__actions">
							<div class="row">
								<div class="col-lg-4 ml-lg-auto">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
									<button type="reset" class="btn btn-warning">Reset</button>
									<button type="submit" class="btn btn-success">Thêm</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="EditItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Sửa thông tin</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="m-form m-form--fit m-form--label-align-right" id="form_edit">
					<div class="m-portlet__body">
						<input type="hidden" name="id">
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Slider *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<select class="form-control m-input" name="tag">
									@if (isset($listSliders) && !empty($listSliders))
									@foreach($listSliders as $key => $value)
									<option value="{{ $key }}">{{ $value }}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="slideFType">
							
						</div>
					</div>
					<div class="m-portlet__foot m-portlet__foot--fit">
						<div class="m-form__actions m-form__actions">
							<div class="row">
								<div class="col-lg-4 ml-lg-auto">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
									<button type="reset" class="btn btn-warning">Reset</button>
									<button type="submit" class="btn btn-success">Sửa</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div><div class="modal fade" id="ShowItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Chi tiết thông tin</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row show-header">
					<img src="" class="avatar">
				</div>
				<div class="show-content row">
					<div class="col-md-6">
						<div>
							<p class="title">Tên phim</p>
							<p class="name"></p>
						</div>
						<div>
							<p class="title">Tên tiếng anh</p>
							<p class="othername"></p>
						</div>
						<div>
							<p class="title">Đạo diễn</p>
							<p class="director"></p>
						</div>
						<div>
							<p class="title">Quốc gia</p>
							<p class="country"></p>
						</div>
						<div>
							<p class="title">Thể loại</p>
							<p class="category"></p>
						</div>
						<div>
							<p class="title">Diễn viên</p>
							<p class="actor">
							</p>
						</div>
					</div>
					<div class="col-md-6">
						<div>
							<p class="title">Hình thức phim</p>
							<p class="type"></p>
						</div>
						<div>
							<p class="title">Năm phát hành</p>
							<p class="year"></p>
						</div>
						<div class="show_release_date">
							<p class="title">Ngày phát hành</p>
							<p class="release_date"></p>
						</div>
						<div>
							<p class="title">Tổng số tập phim</p>
							<p class="total_episodes"></p>
						</div>
						<div>
							<p class="title">Nội dung phim</p>
							<p class="description"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
@include('admin.components.handle-bars.result-search')
@include('admin.components.handle-bars.tag')
@include('admin.components.handle-bars.search')
@include('admin.components.handle-bars.edit-search')
@include('admin.components.handle-bars.first-slider')
<script type="text/javascript" src="{{ asset('assets/admin/js/manage-slider.js') }}"></script>
@endsection