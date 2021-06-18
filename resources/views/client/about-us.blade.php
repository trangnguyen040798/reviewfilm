@extends('client.layouts.master')
@section('content')
<div class="single-page-agile-main">
	<div class="container">
		<!-- /w3l-medile-movies-grids -->
		<div class="agileits-single-top">
			<ol class="breadcrumb">
				<li>
					<a href="{{ route('client.index') }}">Trang chủ</a>
				</li>
				<li class="active">Thông tin liên lạc</li>
			</ol>
		</div>
		<!---728x90--->
		<div class="single-page-agile-info">
			<!--design inspiration kompava.sk-->
			<article class="stores-map">

				<div id="store_bratislava" class="stores-map__main">
					<div class="stores js-stores">
						<div class="map-wrapper">
							<img src="https://images.unsplash.com/photo-1581922819941-6ab31ab79afc?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80" alt="Bratislava" class="map">
							<div class="map-point map-point-bratislava">
								<div class="map-point__marker"></div>
								<div class="map-point__marker-radar"></div>
								<div class="map-point__tooltip"><a href="https://goo.gl/maps/iYNs91nBecQfjxHq8">Open in Google Maps</a></div>
							</div>
						</div>

						<div class="content-wrapper">
							<div class="container">
								<div class="row">
									<div class="content-store col-lg-4 col-md-5 col-sm-6 col-xs-12">
										<div class="content-store__inner">
											<h2 class="content-store__title">ChangReview</h2>
											<div class="content-store__contact">
												<ul class="contact-list">
													<li class="contatct-list__item mail">
														<div class="contact-list__item__wrapper">
															<div class="contact__icon phone-icon"><i class="fa fa-map-marker"></i></div>
															<div class="contact__inner">
																<h4 class="contact__label">Địa Chỉ</h4>
																<div class="contact__value">Số 1 , Đại Cồ Việt, Hai Bà Trưng, hà Nội</div>
															</div>
														</div>
													</li>
													<li class="contatct-list__item number">
														<div class="contact-list__item__wrapper">
															<div class="contact__icon phone-icon"><i class="fa fa-phone"></i></div>
															<div class="contact__inner">
																<h4 class="contact__label">Số điện thoại</h4>
																<div class="contact__value">+421186446818</div>
															</div>
														</div>
													</li>
													<li class="contatct-list__item mail">
														<a href="mailto:trangntt040798@gmail.com" class="contact-list__item__wrapper">
															<div class="contact__icon phone-icon"><i class="fa fa-envelope-open"></i></div>
															<div class="contact__inner">
																<h4 class="contact__label">E-mail</h4>
																<div class="contact__value">trangntt040798@gmail.com</div>
															</div>
														</a>
													</li>
												</ul> 
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</article>
	</div>
</div>
</div>
@endsection
@section('link')
<link rel="stylesheet" href="{{ asset('assets/client/css/about-us.css') }}">
@endsection
