@extends('admin.layouts.master')
@section('title')
Quản lý danh mục
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    @include('admin.components.sub-header', ['title' => 'Quản lý phim'])
    <div class="m-content m-portlet">
        <button class="btn btn-danger multi-delete">
            <i class="fa fa-trash-o"></i> Xóa <span class="count-delete"></span>
        </button>
        <button class="btn m-btn m-btn--gradient-from-focus m-btn--gradient-to-danger" data-target="#AddItem" data-toggle="modal" id="addFilm"><i class="fa fa-plus"></i> Thêm mới</button>
        @include('admin.components.table.table-1', ['titles' => array("Ảnh", "Tên", "Năm phát hành", "Hình thức phim", "Trạng thái", "Được tạo bởi"), 'data' => $data, 'buttons' => array('manage', 'show', 'edit', 'delete', 'status'), 'key' => 'film'])
    </div>
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('assets/admin/css/film.css') }}">
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
                                    <input name="image" type="file" class="file" data-browse-on-zone-click="true" data-show-upload="false">
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Tên phim *</label>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class='input-group'>
                                    <input type='text' class="form-control m-input m-required" name="name" placeholder="Nhập tên" />
                                </div>
                                <span class="error error-required"></span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Tên tiếng anh *</label>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class='input-group'>
                                    <input type='text' class="form-control m-input m-required" name="othername" placeholder="Nhập tên" />
                                </div>
                                <span class="error error-required"></span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Hình thức phim *</label>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class='input-group'>
                                    <select class="form-control m-input" name="type">
                                        @foreach($types as $key => $value)
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
                                    <select class="form-control m-input" name="country_id">
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
                                    <select class="form-control m-input" name="director_id">
                                        <option value="unknown">Unknown</option>
                                        @foreach($directors as $key => $value)
                                        <option value="{{$value['id']}}">{{$value['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Diễn viên *</label>
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
                                <select class="form-control m-input select2-categories" name="categories[]"  multiple="multiple">
                                    @foreach($categories as $value)
                                    <option value="{{$value['id']}}">{{$value['title']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Năm phát hành *</label>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class='input-group'>
                                    <input type='text' class="form-control m-input m-required" name="year" placeholder="Nhập năm phát hành" />
                                </div>
                                <span class="error error-required"></span>
                            </div>
                        </div>
                        <div class="more-info">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Ngày phát hành </label>
                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <div class='input-group date'>
                                        <input type="text" class="form-control m-input" readonly="" placeholder="Select date" id="m_datepicker_2" name="release_date">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Tổng số tập phim </label>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class='input-group'>
                                    <input type='text' class="form-control m-input m-required" name="total_episodes" placeholder="Nhập tổng số tập" />
                                </div>
                                <span class="error error-required"></span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Nội dung phim(tóm tắt) </label>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class='input-group'>
                                    <textarea name="description1" placeholder="Mời nhập nội dung .."></textarea>
                                </div>
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
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Ảnh</label>
                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <div class='input-group input-b1'>
                                        <input id="input-repl-1a" name="image" type="file" accept="image/*" data-browse-on-zone-click="true" data-show-upload="false">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Tên phim *</label>
                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <div class='input-group'>
                                        <input type='text' class="form-control m-input m-required" name="name" placeholder="Nhập tên" />
                                    </div>
                                    <span class="error error-required"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Tên tiếng anh *</label>
                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <div class='input-group'>
                                        <input type='text' class="form-control m-input m-required" name="othername" placeholder="Nhập tên" />
                                    </div>
                                    <span class="error error-required"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Hình thức phim *</label>
                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <div class='input-group'>
                                        <select class="form-control m-input" name="type">
                                            @foreach($types as $key => $value)
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
                                        <select class="form-control m-input" name="country_id">
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
                                        <select class="form-control m-input" name="director_id">
                                            <option value="unknown">Unknown</option>
                                            @foreach($directors as $key => $value)
                                            <option value="{{$value['id']}}">{{$value['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Diễn viên *</label>
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
                                    <select class="form-control m-input select2-categories" name="categories[]"  multiple="multiple">
                                        @foreach($categories as $value)
                                        <option value="{{$value['id']}}">{{$value['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Năm phát hành *</label>
                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <div class='input-group'>
                                        <input type='text' class="form-control m-input m-required" name="year" placeholder="Nhập năm phát hành" />
                                    </div>
                                    <span class="error error-required"></span>
                                </div>
                            </div>
                            <div class="more-info">
                                <div class="form-group m-form__group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Ngày phát hành </label>
                                    <div class="col-lg-9 col-md-8 col-sm-12">
                                        <div class='input-group date'>
                                            <input type="text" class="form-control m-input" readonly="" placeholder="Select date" id="m_datepicker_1" name="release_date">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Tổng số tập phim </label>
                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <div class='input-group'>
                                        <input type='text' class="form-control m-input m-required" name="total_episodes" placeholder="Nhập tổng số tập" />
                                    </div>
                                    <span class="error error-required"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Nội dung phim(tóm tắt) </label>
                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class='input-group'>
                                    <textarea name="description2" placeholder="Mời nhập nội dung .."></textarea>
                                </div>
                                <span class="error error-required"></span>
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
                                    <button type="submit" class="btn btn-success">Sửa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
@include('admin.components.handle-bars.tag')
<script>
    let odd_film_type = {{$odd_film_type}};
</script>
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/film.js') }}"></script>
@endsection
