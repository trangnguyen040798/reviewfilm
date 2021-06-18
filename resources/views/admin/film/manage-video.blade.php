@extends('admin.layouts.master')
@section('title')
Quản lý video
@endsection
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    @include('admin.components.sub-header', ['title' => 'Quản lý video', 'links' => $links])
    <div class="m-content m-portlet">
        <button class="btn btn-danger multi-delete">
            <i class="fa fa-trash-o"></i> Xóa <span class="count-delete"></span>
        </button>
        @if($isUser)
        <a href="{{route('admin.film.manage-video.create', [$film_id])}}"><button class="btn m-btn m-btn--gradient-from-focus m-btn--gradient-to-danger" id="addManageVideo"><i class="fa fa-plus"></i> Thêm mới</button></a>
        @endif
        @include('admin.components.table.table-1', ['titles' => array("Ảnh", "Video", "Tập", "Tình trạng"), 'data' => $data, 'isUser' => $isUser, 'buttons' => array('editVideo', 'delete'), 'key' => 'manage-video'])
    </div>
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('assets/admin/css/manage-video.css') }}">
@endsection
@section('modal')
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
				
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
    let film_id = {{ $film_id }}
</script>
<script type="text/javascript" src="{{ asset('assets/admin/js/manage-video.js') }}"></script>
@endsection
