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
				<li>
					<a href="{{ route('client.film.manage-video.index', [$film_id]) }}">{{ $film->name }} - Quản lý video ( {{ $film->type . ' - ' . $film->total_episodes }} tập video )</a>
				</li>
				<li class="active">
					Tạo video
				</li>
			</ol>
		</div>
		<div class="agileinfo-news-top-grids">
			<div class="loading">
				<div class="loadingio-spinner-spinner-6yd77xx7ddu"><div class="ldio-bzdyfz7fhf">
					<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
				</div></div>
				<div class="overlay">
					
				</div>
			</div>
			<div class="tour-tabs">
				<div class="col-sm-4 content_tab">
					<div class="dd nestable tab1 active" id="nestable">
						<form id="combineVideo">
							<ol class="dd-list">
								
							</ol>
							
						</form>
					</div>
					<div class="tab2 combine-audio">
						
					</div>
					<div class="tab3 sound-bg">
						
					</div>
					<div class="tab4 final-video">
						
					</div>
				</div>
				<div class="m-grid__item m-grid__item--fluid m-wrapper col-sm-8">
					<div class="m-content m-portlet">
						<div>
							<div class="form-group">
								<label for="">Tập :</label>
								@if($film->isSeries)
								<input type="text" name="episode" @if(\Illuminate\Support\Facades\Session::has('episode')) value="{{ \Illuminate\Support\Facades\Session::get('episode')}}" readonly @endif class="form-control">
								@else
								<input type="text" name="episode" value="1" readonly class="form-control">
								@endif
							</div>
							<nav>
								<ul class="title_tab">
									<li class="tab1 active">
										<label for="tab1">Ghép video</label>
									</li>
									<li class="tab2">
										<label for="tab2">Tạo văn bản thành lời nói</label>
									</li>
									<li class="tab3">
										<label for="tab3">Thêm nhạc nền</label>
									</li>
									<li class="tab4">
										<label for="tab4">Tạo video</label>
									</li>
								</ul>
							</nav>
							<div class="content_tab">
								<div class="tab1 active">
									<form class="uploadVideo">
										<input type="hidden" value="{{ $isUpdated }}" name="isUpdated">
										<input type="hidden" value="{{ $film_id }}" name="film_id">
										<div class="file-loading">            
											<input name="file[]" type="file" data-browse-on-zone-click="true" multiple class="file" accept="video/mp4">
										</div>
										<button class="btn btn-secondary btn-combine-video" type="submit"><i class="fa fa-upload" aria-hidden="true"></i>
										Upload</button>
									</form>
									<div class="combine-video">
									</div>
								</div>
								<div class="tab2">
									<div class="select-ai">
										@if(isset($filters) && !empty($filters))
										@foreach($filters as $key => $filter)
										<button class="@if($key == 'google')active-btn @endif btn btn-secondary">{{ $filter }}</button>
										@endforeach
										@endif
									</div>
									<form id="createAudio">
										<input type="hidden" value="{{ $isUpdated }}" name="isUpdated">
										<input type="hidden" value="{{ $film_id }}" name="film_id">
										<input type="hidden" name="type" id="type-ai" value="{{ $filters['google'] }}">
										<div class="d-flex filter">
											<div class="">
												<label for="">Tốc độ</label>
												<div class="speed-box">
													<input type="range" value="{{ $speeds['default'] }}" min="{{ $speeds['min'] }}" max="{{ $speeds['max'] }}" step="{{ $speeds['step'] }}" oninput="rangevalue.value=value" class="speed"/>
													<output id="rangevalue">{{ $speeds['default'] }}</output>
												</div>
											</div>
										</div>
										<div class="content-audio">
											<textarea name="audio" placeholder="Nhập văn bản ..."></textarea>
											<p id="count-characters"></p>
										</div>
										<button class="btn btn-success" type="submit">Tạo</button>
									</form>
									{{-- <div class="combine-audio">
									</div> --}}
								</div>
								<div class="tab3">
									<form id = "addSoundBG">
										<input type="hidden" value="{{ $isUpdated }}" name="isUpdated">
										<input type="hidden" name="film_id" value="{{ $film_id }}">
										<div class="row">
											<div class="col-md-9">
												<div class="file-loading">   
													<input name="sound_bg" type="file" accept="audio/*" data-browse-on-zone-click="true" data-show-upload="false">
												</div>
												<button class="btn btn-secondary " type="submit"><i class="fa fa-upload" aria-hidden="true"></i>Upload</button>
											</div>
											<div class="col-md-3">
												<label>Volume </label>
												<input type="range" value="1.0" min="0.25" max="2.0" step="0.25" oninput="rangevalue2.value=value" class="volume"/>
												<output id="rangevalue2">1.0</output>
											</div>
										</div>
									</form>
								</div>
								<div class="tab4">
									<form id="createFinalVideo">
										<input type="hidden" name=film_id value="{{$film_id}}">
										<input type="hidden" value="{{ $isUpdated }}" name="isUpdated">
										<div class="file-loading">            
											<input name="image_video" type="file" data-browse-on-zone-click="true" accept="image/*" data-browse-on-zone-click="true" data-show-upload="false">
										</div>
										<button class="btn btn-secondary">Tạo</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('bower_components/bower/admin/mycss/fileinput.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<link rel="stylesheet" href="{{ asset('assets/admin/css/manage-video.css') }}">
<link rel="stylesheet" href="{{ asset('assets/client/css/create-video.css') }}">
@endsection
@section('script')
<script type="text/javascript" src="https://plugins.krajee.com/assets/be8d71af/js/fileinput.min.js?ver=201909132002"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
@include('admin.components.handle-bars.video')
@include('admin.components.handle-bars.audio')
@include('client.components.handle-bars.filter-ai')
@include('client.components.handle-bars.preview-video')
<script>
	let film_id = {{ $film_id }};
</script>
<script type="text/javascript" src="{{ asset('assets/client/js/create-video.js') }}"></script>
@endsection