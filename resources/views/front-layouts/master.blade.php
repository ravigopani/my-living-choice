<!DOCTYPE html>
<html lang="en">
<head>
	@include('front-layouts.header')
</head>
<body id="page-top"> 
    <div class="body">
        <!-- HEADER -->
        @include('front-layouts.navbar')
        <!-- HEADER -->

        <!-- INTRO -->
        @yield('content')
        <!-- INTRO -->

        <!--footer-->
        @include('front-layouts.footer')
        <!--footer-->
    </div>       
</body>
</html>
