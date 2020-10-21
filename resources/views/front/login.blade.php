<!DOCTYPE html>
<html lang="en">
<head>
	@include('front-layouts.header')
</head>
<body id="page-top"> 
    <div class="body">
        <!--header-->
        <header>
            <div class="login_header">
                <div class="site_logo text-center">
                    <img src="{{URL::asset('public/front/images/Logo.png')}}" />
                </div>
            </div>
        </header>
        <!--header-->

        <div id="login" class="login_page d-flex" style="background-image: url(public/front/images/login-bg.jpg);">
            <div class="container align-self-center">
                <div class="row no-gutters">
                    <div class="login_form_wrapper">
                        <div class="form-heading-block text-center">
                            <h1 class="heading-title">Login Your Acount</h1>
                        </div>
                        <div id="wppb-login-wrap" class="wppb-user-forms">
                            <form name="loginform" id="loginform" method="POST" action="{{ route('login') }}"> 
                                @csrf
                                <p class="login-username">
                                    <input id="email" type="email" class="input" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                                </p>
                                <p class="login-password">
                                    <input id="password" type="password" class="input" name="password" placeholder="Password" required>
                                </p>
                                <p class="login-submit">
                                    <input type="submit" name="wp-submit" id="wppb-submit" class="button button-primary" value="Login">
                                </p> 
                            </form>
                            <p class="login-register-lost-password text-center">
                                <a href="https://www.mylivingchoice.com/forgot-password/">Forgot your password?</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--footer-->
        <footer>
            <div class="footer_copyright_text">
                <div class="container">
                    <div class="footer_copyright_title">
                        <h2 class="heading-title">Copyright@mylivingchoice</h2>
                    </div>
                </div>
            </div>
        </footer>
        <!--footer-->
    </div>

 <!-- JAVASCRIPT =============================-->
 <script src="{{URL::asset('public/front/js/jquery-3.5.1.min.js')}}"></script>
 <script src="{{URL::asset('public/front/js/bootstrap.min.js')}}"></script>
 <script src="{{URL::asset('public/front/js/custom.js')}}"></script>
</body>
</html>