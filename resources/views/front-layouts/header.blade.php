<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="My Living Choice helps to find top-rated senior living communities with our list of pre-vetted and reputable communities that care for you or your loved one to stay healthy.">
<meta name="keywords" content="">
<meta name="author" content="">
<title>My Living Choice - Find Best Senior Living Community Near You</title>
<!-- FAVICON -->
<link rel="shortcut icon" href="">
<!-- BOOTSTRAP -->
<link rel="stylesheet" href="{{URL::asset('public/front/css/bootstrap.min.css')}}">
<!-- ICONS -->
<link rel="stylesheet" href="{{URL::asset('public/front/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('public/front/css/all.css')}}">
<!-- THEME  CSS -->
<link rel="stylesheet" href="{{URL::asset('public/front/css/style.css')}}">
<link href="{{URL::asset('public/css/custom_style.css')}}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{URL::asset('public/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('public/js/custom_js_front.js')}}"></script>

<script>
	var BASE_URL = "{{url(\Config::get('constants.BASE_URL'))}}/";
	var ADMIN_URL = "{{url(\Config::get('constants.ADMIN_URL'))}}/";
</script>