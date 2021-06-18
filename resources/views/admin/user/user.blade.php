@extends('admin.layouts.master')
@section('title')
Quản lý người dùng
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	@include('admin.components.sub-header', ['title' => 'Quản lý người dùng'])
	<div class="m-content m-portlet">
		<button class="btn btn-danger multi-delete">
			<i class="fa fa-trash-o"></i> Xóa <span class="count-delete"></span>
		</button>
		<button class="btn m-btn m-btn--gradient-from-focus m-btn--gradient-to-danger" data-target="#AddItem" data-toggle="modal" id="addUser"><i class="fa fa-plus"></i> Thêm mới</button>
		@include('admin.components.table.table-1', ['titles' => array("Ảnh", "Họ và tên", 'Email'), 'data' => $data, 'buttons' => array('show', 'edit', 'delete'), 'key' => 'user'])
	</div>
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('assets/admin/css/user.css') }}">
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
							<label class="col-form-label col-lg-3 col-sm-12">Tên tài khoản *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type='text' class="form-control m-input m-required" name="name" placeholder="Nhập tên" />
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Email *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type='text' class="form-control m-input m-required m-email" name="email" placeholder="Nhập email" />
								</div>
								<span class="error error-required error-email"></span>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Ảnh</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group input-b1'>
									<input id="input-b1" name="input-b1" type="file" class="file" data-browse-on-zone-click="true" data-show-upload="false" accept="image/*">
								</div>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Vai trò *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<select class="form-control m-input" name="role">
									{{-- <option value="admin">Admin</option> --}}
									<option value="customer">Khách hàng</option>
								</select>
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
				<h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="m-form m-form--fit m-form--label-align-right" id="form_edit">
					<div class="m-portlet__body">
						<input type="hidden" name="id">
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Tên tài khoản *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type='text' class="form-control m-input m-required" name="name" placeholder="Nhập tên" />
								</div>
								<span class="error error-required"></span>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Email *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group'>
									<input type='text' class="form-control m-input m-required m-email" name="email" placeholder="Nhập email" />
								</div>
								<span class="error error-required error-email"></span>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Ảnh</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<div class='input-group input-b1'>
									{{-- <input id="input-b2" name="input-b1" type="file" class="file" data-browse-on-zone-click="true" data-show-upload="false" accept="image/*"> --}}
									<div class="file-loading">
										<input id="input-repl-1a" name="input-repl-1a" type="file" accept="image/*" data-browse-on-zone-click="true" data-show-upload="false"  accept="image/*">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label class="col-form-label col-lg-3 col-sm-12">Vai trò *</label>
							<div class="col-lg-9 col-md-8 col-sm-12">
								<select class="form-control m-input" name="role">
									{{-- <option value="admin">Admin</option> --}}
									<option value="customer">Khách hàng</option>
								</select>
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
							<p class="title">Tên đăng nhập</p>
							<p class="name"></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="show-email">
							<p class="title">Email</p>
							<p class="email"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('assets/admin/js/user.js') }}"></script>
@endsection