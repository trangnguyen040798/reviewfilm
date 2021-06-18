@extends('admin.layouts.master')
@section('title')
Quản lý bản tin
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	@include('admin.components.sub-header', ['title' => 'Quản lý bản tin'])
	<div class="m-content m-portlet">
		<button class="btn btn-danger multi-delete">
			<i class="fa fa-trash-o"></i> Xóa <span class="count-delete"></span>
		</button>
		<button class="btn m-btn m-btn--gradient-from-focus m-btn--gradient-to-danger" data-target="#AddItem" data-toggle="modal" id="addNews"><i class="fa fa-plus"></i> Thêm mới</button>
		@include('admin.components.table.table-1', ['titles' => array("Ảnh", "Tiêu đề", "Lượt xem"), 'data' => $data, 'buttons' => array('show', 'edit', 'delete'), 'key' => 'news'])
	</div>
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('assets/admin/css/news.css') }}">
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
							<label class="col-form-label col-lg-3 col-sm-12">Ảnh</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group input-b1'>
									<input id="input-b1" name="image" type="file" class="file m-required" data-browse-on-zone-click="true" data-show-upload="false" accept="image/*">
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Tiêu đề bản tin *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type='text' class="form-control m-input m-required" name="title" placeholder="Nhập tiêu đề" />
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
						<div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Thể loại *</label>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <select class="form-control m-input" name="category_id">
                                    @foreach($categories as $value)
                                    <option value="{{$value['id']}}">{{$value['title']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Nội dung *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
                                <textarea name="content" placeholder="Nội dung bản tin ..." class="m-required"></textarea>
                                <span class="error error-required"></span>
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
							<label class="col-form-label col-lg-3 col-sm-12">Ảnh</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
								<input name="update_image" type="file" accept="image/*" data-browse-on-zone-click="true" data-show-upload="false">
								</div>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Tiêu đề bản tin *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type='text' class="form-control m-input m-required" name="title" placeholder="Nhập tiêu đề" />
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
						<div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Thể loại *</label>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <select class="form-control m-input" name="category_id">
                                    @foreach($categories as $value)
                                    <option value="{{$value['id']}}">{{$value['title']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Nội dung *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
                                <textarea name="update_content" placeholder="Nội dung bản tin ..."></textarea>
							</div>
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
<div class="modal fade" id="ShowItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
						<div class="show-name">
							<p class="title">Tiêu đề bản tin</p>
							<p class="name"></p>
						</div>
						<div class="show-occupation">
							<p class="title">Thể loại</p>
							<p class="category"></p>
						</div>
						<div class="show-country">
							<p class="title">Lượt xem</p>
							<p class="views"></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="show-story">
							<p class="title">Nội dung</p>
							<p class="content"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('assets/admin/js/news.js') }}"></script>
@endsection