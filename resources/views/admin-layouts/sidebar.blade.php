<div class="sidebar sidebar-main sidebar-fixed">
	<div class="sidebar-content">
		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">
					<li class="nav-item {{ (Request::is('admin/user') || Request::is('admin/user/*') ? 'active' : '') }}">
						<a href="{{url(\Config::get('constants.ADMIN_URL')).'/user'}}"><i class="icon-users4"></i> <span>User Management</span></a>
					</li>
					<li class="nav-item {{ (Request::is('admin/property') || Request::is('admin/property/*') ? 'active' : '') }}">
						<a href="{{url(\Config::get('constants.ADMIN_URL')).'/property'}}"><i class="icon-office"></i> <span>Property Management</span></a>
					</li>
					<li>
						<a href="{{url(\Config::get('constants.ADMIN_URL')).'/showroom'}}"><i class="icon-office"></i> <span>Request Reviews</span></a>
					</li>
					<li>
						<a href="{{url(\Config::get('constants.ADMIN_URL')).'/social_media'}}"><i class="icon-users4"></i> <span>Review Lists</span></a>
					</li>
					<li class="nav-item {{ (Request::is('admin/blog') || Request::is('admin/blog/*') ? 'active' : '') }}">
						<a href="{{url(\Config::get('constants.ADMIN_URL')).'/blog'}}"><i class="icon-blog"></i> <span>Blogs</span></a>
					</li>

					<li class="nav-item nav-item-submenu">
						<a href="#" class="nav-link"><i class="icon-cog2"></i> <span>Settings</span></a>
						<ul class="nav nav-group-sub" data-submenu-title="Setting">
							<li class="nav-item {{ (Request::is('admin/care') || Request::is('admin/care/*') ? 'active' : '') }}">
								<a href="{{url(\Config::get('constants.ADMIN_URL')).'/care'}}" class="nav-link">Cares</a>
							</li>
							<li class="nav-item {{ (Request::is('admin/amenity') || Request::is('admin/amenity/*') ? 'active' : '') }}">
								<a href="{{url(\Config::get('constants.ADMIN_URL')).'/amenity'}}" class="nav-link">Amenties</a>
							</li>
							<li class="nav-item {{ (Request::is('admin/package') || Request::is('admin/package/*') ? 'active' : '') }}">
								<a href="{{url(\Config::get('constants.ADMIN_URL')).'/package'}}" class="nav-link">Package</a>
							</li>
							<li class="nav-item {{ (Request::is('admin/state') || Request::is('admin/state/*') ? 'active' : '') }}">
								<a href="{{url(\Config::get('constants.ADMIN_URL')).'/state'}}" class="nav-link">State</a>
							</li>
							<li class="nav-item {{ (Request::is('admin/city') || Request::is('admin/city/*') ? 'active' : '') }}">
								<a href="{{url(\Config::get('constants.ADMIN_URL')).'/city'}}" class="nav-link">City</a>
							</li>
							<li class="nav-item {{ (Request::is('admin/tag') || Request::is('admin/tag/*') ? 'active' : '') }}">
								<a href="{{url(\Config::get('constants.ADMIN_URL')).'/tag'}}" class="nav-link">Tags</a>
							</li>
							<li class="nav-item {{ (Request::is('admin/content_manage') || Request::is('admin/content_manage/*') ? 'active' : '') }}">
								<a href="{{url(\Config::get('constants.ADMIN_URL')).'/content_manage'}}" class="nav-link">Manage Content</a>
							</li>
						</ul>
					</li>

				</ul>
			</div>
		</div>
		<!-- /main navigation -->
	</div>
</div>