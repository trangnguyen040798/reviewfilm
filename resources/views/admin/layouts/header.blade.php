<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->
<head>
	<meta charset="utf-8" />
	<title>@yield('title')</title>
	<meta name="description" content="Latest updates and statistic charts">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	@include('admin.layouts.link')
	<style>
		img {
			max-width: 100% !important;
		}
		body {
			padding-right: 0px !important;
		}
	</style>
	@yield('link')
	<!--end::Base Styles -->
	<!-- <link rel="shortcut icon" href="assets/demo/default/media/img/logo/favicon.ico" /> -->
	@routes
</head>
