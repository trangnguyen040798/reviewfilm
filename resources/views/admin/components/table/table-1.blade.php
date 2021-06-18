<table class="table table-striped- table-bordered table-hover table-checkable dataTable {{$key}}_table_1" id="{{ $key }}_table_1">
	<thead>
		<tr>
			<th style="padding-left: 10px">
				<input type="checkbox" name=checkall>
			</th>
			<th>
				Id
			</th>
			@foreach($titles as $title)
			<th>{{$title}}</th>
			@endforeach
			<th>
				Hành động
			</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $value)
		<tr id="{{ $key }}_{{ $value->id }}">
			<td>
				<input type="checkbox" value="{{ $value->id }}">
			</td>
			<td scope="row">
				<span class="id">{{ $value->id }}</span>
			</td>
			@if($key == 'manage-slider-1' || $key == 'manage-slider-2')
			@include('admin.'.substr($key, 0, -2).'.'.$key.'-table-1', ['value' => $value])
			@else
			@include('admin.'.$key.'.'.$key.'-table-1', ['value' => $value])
			@endif
			<td>
				@foreach($buttons as $button)
				@if($button == 'show')
				<span data-skin="dark" data-toggle="m-tooltip" data-placement="top" data-original-title="Xem">
					<button class="btn btn-primary btn-sm show-item" data-id="{{ $value->id }}" data-toggle="modal" data-target="#ShowItem">
						<i class="fa fa-eye"></i>
					</button>
				</span>
				@elseif($button == 'show-film' && isset($value->film) && !empty($value->film))
				<span data-skin="dark" data-toggle="m-tooltip" data-placement="top" data-original-title="Chi tiết phim">
					<button class="btn btn-primary btn-sm show-item" data-id="{{ $value->film->id }}" data-toggle="modal" data-target="#ShowItem">
						<i class="fa fa-eye"></i>
					</button>
				</span>
				@elseif($button == 'manage')
				@if($key == 'film')
				<a href="{{ route('admin.film.manage-video.index', [$value->id]) }}">
					<button class="btn btn-info btn-sm manage-item" data-id="{{ $value->id }}" data-toggle="modal">
						<i class="fa fa-info"></i>
					</button>
				</a>
				@endif
				@elseif($button == 'edit')
				@if( ($key == 'film' && $value->user_id == auth()->user()->id) || $key != 'film' )
				<span data-skin="dark" data-toggle="m-tooltip" data-placement="top" data-original-title="Sửa">
					<button class="btn btn-warning btn-sm edit-item" data-id="{{ $value->id }}" data-toggle="modal" data-target="#EditItem">
						<i class="fa fa-edit"></i>
					</button>
				</span>
				@endif
				@elseif($button == 'editVideo' && $isUser)
				<a href="{{ route('admin.film.manage-video.edit-video', [$value->film_id, $value->id]) }}">
				<span data-skin="dark" data-toggle="m-tooltip" data-placement="top" data-original-title="Sửa">
					<button class="btn btn-warning btn-sm edit-item" data-id="{{ $value->id }}" data-toggle="modal" data-target="#EditItem">
						<i class="fa fa-edit"></i>
					</button>
				</span>
				</a>
				@elseif($button == 'delete')
				<span data-skin="dark" data-toggle="m-tooltip" data-placement="top" data-original-title="Xóa">
					<button class="btn btn-danger btn-sm delete-item" data-id="{{ $value->id }}">
						<i class="fa fa-trash"></i>
					</button>
				</span>
				@elseif($button == 'status')
				@if($value->status == 0)
				<span data-skin="dark" data-toggle="m-tooltip" data-placement="top" data-original-title="Cập nhật trạng thái">
					<button class="btn btn-secondary btn-sm status-item" status="{{$value->status}}" data-id="{{ $value->id }}">
						<i class="fa fa-toggle-on"></i>
					</button>
				</span>
				@else
				<span data-skin="dark" data-toggle="m-tooltip" data-placement="top" data-original-title="Cập nhật trạng thái">
					<button class="btn btn-success btn-sm status-item" status="{{$value->status}}" data-id="{{ $value->id }}">
						<i class="fa fa-toggle-on"></i>
					</button>
				</span>
				@endif
				@endif
				@endforeach
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
