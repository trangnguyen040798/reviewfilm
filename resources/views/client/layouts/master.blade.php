@include('client.layouts.header')
<body>
	<div class="header">
		<div class="container">
			<div class="w3layouts_logo">
				<a href="{{ route('client.index') }}">
					<h1>Chang<span>Review</span>
					</h1>
				</a>
			</div>
			<div class="w3_search">
				<form action="{{ route('client.film.search') }}" method="POST">
					@csrf
					<input type="text" name="search" placeholder="Search" required>
					<input type="submit" value="Tìm kiếm">
				</form>
			</div>
			<div class="w3l_sign_in_register">
				<ul>
					<li>
						<i class="fa fa-phone" aria-hidden="true">
						</i> (+000) 123 345 653
					</li>
					<li>
						@if(Illuminate\Support\Facades\Auth::check())
						@php 
						$user = Illuminate\Support\Facades\Auth::user();
						@endphp
						<a href="{{ route('client.account.index') }}">{{ $user->name }}</a>
						@else
						<a href="#" data-toggle="modal" data-target="#myModal">Đăng nhập</a>
						@endif
					</li>
				</ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<div class="modal video-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					Đăng nhập &amp; Đăng Ký
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>						
				</div>
				<section>
					<div class="modal-body">
						<div class="w3_login_module">
							@if (session('error'))
							<div class="alert alert-danger">
								<ul>
									@foreach (json_decode(session('error')) as $error)
									<li>{{ $error[0] }}
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button></div>
									</li>
									@endforeach
								</ul>
							</div>
							@endif
							<div class="module form-module">
								<div class="toggle">
									<i class="fa fa-times fa-pencil">
									</i>
									<div class="tooltip">Click Me</div>
								</div>
								<div class="form">
									<h3>Đăng Nhập</h3>
									<form action="{{ route('client.login') }}" method="POST" onsubmit="return ValidateFormLogin()" name="form_login">
										@csrf
										<div>
											<input type="email" name="email" placeholder="Email" @if(session('data')) value="{{ session('data')['email'] }}" @endif>
											<span class="invalid-feedback" role="alert">
												<strong id="error_email_2"></strong>
											</span>
										</div>
										<div>
											<input type="password" name="password" placeholder="Mật Khẩu" @if(session('data')) value="{{ session('data')['password'] }}" @endif>
											<span class="invalid-feedback" role="alert">
												<strong id="error_password_2"></strong>
											</span>
										</div>
										<input type="submit" value="Login">
									</form>
									<a href="{{ route('client.mail-form') }}">Quên mật khẩu ?</a>
								</div>
								<div class="form">
									<h3>Tạo Tài Khoản</h3>
									<form action="{{ route('client.register') }}" method="post" onsubmit="return ValidateForm()" name="form_register">
										<div>
											<input type="text" name="name" placeholder="Name">
											<span class="invalid-feedback" role="alert">
												<strong id="error_name_1"></strong>
											</span> 
										</div>
										<div>
											<input type="email" name="email" placeholder="Email Address">
											<span class="invalid-feedback" role="alert">
												<strong id="error_email_1"></strong>
											</span>
										</div>
										<div>
											<input type="password" name="password" placeholder="Password">
											<span class="invalid-feedback" role="alert">
												<strong id="error_password_1"></strong>
											</span>
										</div>
										<div>
											<input type="password" name="rpassword" placeholder="Confirm Password">
											<span class="invalid-feedback" role="alert">
												<strong id="error_rpassword_1"></strong>
											</span>
										</div>
										<input type="submit" value="Register">
									</form>
								</div>
								<div class="cta">
									<a href="{{ route('client.socialRedirect', 'facebook') }}" class="social-button loginBtn loginBtn--facebook" id="facebook-connect"> <span><i class="fa fa-facebook" aria-hidden="true"></i>
									FaceBook</span></a>
									<a href="{{ route('client.socialRedirect', 'google') }}" class="social-button loginBtn loginBtn--google" id="google-connect"> <span><i class="fa fa-google" aria-hidden="true"></i> Google</span></a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
	<div class="movies_nav">
		<div class="container">
			<nav class="navbar navbar-default">
				<div class="navbar-header navbar-left">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar">
						</span>
						<span class="icon-bar">
						</span>
						<span class="icon-bar">
						</span>
					</button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
					<nav>
						<ul class="nav navbar-nav">
							<li class="active">
								<a href="{{ route('client.index') }}">Trang Chủ</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Thể Loại 
									<b class="caret">
									</b>
								</a>
								<ul class="dropdown-menu multi-column columns-3">
									<li>
										@if (isset($cateFilms) && !empty($cateFilms))
										@php
										$number = ceil(count($cateFilms) / 3);
										@endphp
										@foreach($cateFilms as $key => $cate)
										@if(($key >= 0 && $key <= $number) || ($key > $number && $key <= (2 * $number) || ($key > (2* $number))))
											<div class="col-sm-4">
												<ul class="multi-column-dropdown">
													<li>
														<a href="{{ route('client.category.cate', [ 'film', $cate->slug ]) }}">{{ $cate['title'] }}</a>
													</li>
												</ul>
											</div>
											@endif
											@endforeach
											@endif
											<div class="clearfix">
											</div>
										</li>
									</ul>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hình Thức 
										<b class="caret">
										</b>
									</a>
									<ul class="dropdown-menu multi-column multi-column-2 columns-3">
										<li>
											@if(isset($typeFilms) && !empty($typeFilms))
											@foreach($typeFilms as $key => $type)
											<div class="col-sm-6">
												<ul class="multi-column-dropdown">
													<li>
														<a href="{{ route('client.category.cate', ['type', $key ]) }}">{{ $type }}</a>
													</li>
												</ul>
											</div>
											@endforeach
											@endif
											<div class="clearfix">
											</div>
										</li>
									</ul>
								</li>
								<li>
									<a href="{{ route('client.news.cate')}}">Bản tin</a>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Quốc Gia 
										<b class="caret">
										</b>
									</a>
									<ul class="dropdown-menu multi-column multi-column-2  columns-3">
										<li>
											@if (isset($countries) && !empty($countries))
											@php
											$number = ceil(count($countries) / 3);
											@endphp
											@foreach($countries as $key => $country)
											@if(($key >= 0 && $key <= $number) || ($key > $number && $key <= (2 * $number) || ($key > (2* $number))))
												<div class="col-sm-4">
													<ul class="multi-column-dropdown">
														<li>
															<a href="{{ route('client.category.cate', ['country', $country->slug ]) }}">{{ $country['title'] }}</a>
														</li>
													</ul>
												</div>
												@endif
												@endforeach
												@endif
												<div class="clearfix">
												</div>
											</li>
										</ul>
									</li>
									<li>
										<a href="{{ route('client.about-us') }}">Thông tin liên lạc</a>
									</li>
								</ul>
							</nav>
						</div>
					</nav>	
				</div>
			</div>
			@yield('content')
			@include('client.layouts.footer')
