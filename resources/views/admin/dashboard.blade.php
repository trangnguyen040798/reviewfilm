@extends('admin.layouts.master')
@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	@include('admin.components.sub-header', ['title' => 'Dashboard'])
	<div class="m-content">
		@if (session('success'))
		<div class="alert alert-info" role="alert" style="font-size: 16px">{{session('success')}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding-top: 0">
			<span aria-hidden="true">&times;</span>
		</button></div>
		@endif
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/js/dashboard.js') }}" type="text/javascript"></script>
@endsection
@section('title')
Dashboard
@endsection
