<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-header bwhite" style="max-width: 259px;">
		<a class="navbar-brand p0" href="{{url('/admin/')}}">
			<img src="{{URL::asset('public/image/My-Living-Choice-Logo.png')}}" alt="Site Logo" class="m0 w100 h100">
		</a>

		<ul class="nav navbar-nav visible-xs-block">
			<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
		</ul>
	</div>

	<div class="navbar-collapse collapse" id="navbar-mobile">
		<ul class="nav navbar-nav">
			<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
		</ul>

		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown dropdown-user">
				<a class="dropdown-toggle" data-toggle="dropdown">
					@php 
						$profile_image_login = \Illuminate\Support\Facades\Session::get('profile_image'); 
					@endphp	
					@if(!empty($profile_image_login) && file_exists(storage_path().'/userProfilePicture/'.$profile_image_login))				      	
				      	<img src="{{URL('').'/get_image/userProfilePicture/'.$profile_image_login}}" class="rounded-circle mr-3" height="34" width="34" alt="">
					@else
		        		<img src="{{URL::asset('public/image/user_avatar.png')}}" class="rounded-circle mr-3" height="34" width="34" alt="">
					@endif

					
					<span>{{ Auth::user()->name }}</span>
					<i class="caret"></i>
				</a>

				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="{{url('')}}/admin/profile_edit"><i class="icon-user"></i> Edit Profile</a></li>
					<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').	submit();"><i class="icon-switch2"></i> Logout</a></li>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
				</ul>
			</li>
		</ul>
	</div>
</div>