<!-- BEGIN: Aside Menu -->
<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
	<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
		<li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
			<a href="index.html" class="m-menu__link ">
				<i class="m-menu__link-icon flaticon-line-graph"></i>
				<span class="m-menu__link-title">
					<span class="m-menu__link-wrap">
						<span class="m-menu__link-text">Dashboard</span>
						<span class="m-menu__link-badge">
							<span class="m-badge m-badge--danger">2</span>
						</span>
					</span>
				</span>
			</a>
		</li>
		<li class="m-menu__section ">
			<h4 class="m-menu__section-text">Components</h4>
			<i class="m-menu__section-icon flaticon-more-v3"></i>
		</li>
		<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
			<a href="#m-menu__submenu-1" class="m-menu__link" data-toggle="collapse" role="button" aria-controls="m-menu__submenu-1" aria-expanded="false">
				<i class="m-menu__link-icon flaticon-layers"></i>
				<span class="m-menu__link-text">Quản lý người dùng</span>
				<i class="m-menu__ver-arrow la la-angle-right"></i>
			</a>
			<div class="m-menu__submenu collapse" id="m-menu__submenu-1">
				<span class="m-menu__arrow"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
						<span class="m-menu__link">
							<span class="m-menu__link-text">Quản lý người dùng</span>
						</span>
					</li>
					<li class="m-menu__item" aria-haspopup="true">
						<a href="{{ route('admin.user.index') }}" class="m-menu__link ">
							<i class="m-menu__link-bullet m-menu__link-bullet--dot">
								<span></span>
							</i>
							<span class="m-menu__link-text">Quản lý người dùng</span>
						</a>
					</li>
					<li class="m-menu__item" aria-haspopup="true">
						<a href="{{ route('admin.artist.index')}}" class="m-menu__link ">
							<i class="m-menu__link-bullet m-menu__link-bullet--dot">
								<span></span>
							</i>
							<span class="m-menu__link-text">Quản lý nghệ sĩ</span>
						</a>
					</li>
				</ul>
			</div>
		</li>
		<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
			<a href="{{ route('admin.country.index') }}" class="m-menu__link">
				<i class="m-menu__link-icon flaticon-layers"></i>
				<span class="m-menu__link-text">Quản lý quôc gia</span>
			</a>
		</li>
		<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
			<a href="{{ route('admin.category.index') }}" class="m-menu__link">
				<i class="m-menu__link-icon flaticon-layers"></i>
				<span class="m-menu__link-text">Quản lý danh mục</span>
			</a>
		</li>
		<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
			<a href="{{ route('admin.film.index') }}" class="m-menu__link" >
				<i class="m-menu__link-icon flaticon-layers"></i>
				<span class="m-menu__link-text">Quản lý phim</span>
			</a>
		</li>
		<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
			<a href="{{ route('admin.news.index') }}" class="m-menu__link" >
				<i class="m-menu__link-icon flaticon-layers"></i>
				<span class="m-menu__link-text">Quản lý bản tin</span>
			</a>
		</li>
		<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
			<a href="{{ route('admin.manage-slider.index') }}" class="m-menu__link" >
				<i class="m-menu__link-icon flaticon-layers"></i>
				<span class="m-menu__link-text">Quản lý slider</span>
			</a>
		</li>
	</ul>
</div>