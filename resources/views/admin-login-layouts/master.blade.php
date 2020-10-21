<!DOCTYPE html>
<html>
<head>
	<title>Ceramicwala | @yield('title')</title>

	@include('admin-login-layouts.header')

	<script>
		var BASE_URL = "{{ URL('') }}/";
	</script>

	@yield('head-content')

</head>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<body class="login-container">
	<div class="loading"></div>
	<!-- Main navbar -->
	@include('admin-login-layouts.navbar')
	<!-- /main navbar -->

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Main form Content -->
					@yield('content')
					<!-- /Main form Content -->

					<!-- Footer -->
					@include('admin-login-layouts.footer')
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

	@yield('footer-content')

</body>
</html>
