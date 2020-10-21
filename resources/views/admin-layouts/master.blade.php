<!DOCTYPE html>
<html>
<head>
	<title>My Living Choice | @yield('title')</title>
	
	@include('admin-layouts.header')

	<script>
		var BASE_URL = "{{url(\Config::get('constants.BASE_URL'))}}/";
		var ADMIN_URL = "{{url(\Config::get('constants.ADMIN_URL'))}}/";
		var global_file_change_check = false;
	</script>

	@yield('head-content')

</head>
<body>
	<div class="loading"></div>

	@include('admin-layouts.navbar')

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			@include('admin-layouts.sidebar')
			<!-- /main sidebar -->

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Breadcrumb -->
				<div class="page-header page-header-default" style="margin-top: 48px;">
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							{{-- <li><a href="{{url('/admin/')}}/"><i class="icon-home2 position-left"></i> Home</a></li> --}}
							@yield('breadcrumb')
						</ul>

						@yield('section-add-more-button')

					</div>
				</div>
				<!-- /Breadcrumb -->


				<!-- Content area -->
				<div class="content">
					
					@if(session('status'))
				        <script type="text/javascript">show_notification('{{session('status')}}','{{ session('message') }}')</script>
				    @endif

					@yield('content')
					
					<!-- Footer -->
					@include('admin-layouts.footer')
					<!-- /footer -->
				</div>
			</div>
				<!-- /content area -->
		</div>
			<!-- /main content -->
	</div>
		<!-- /page content -->
	<!-- /page container -->
</body>
</html>