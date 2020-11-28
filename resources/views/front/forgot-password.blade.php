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
                    <a href="{{url('')}}">
                        <img src="{{URL::asset('public/front/images/Logo.png')}}" />
                    </a>
                </div>
            </div>
        </header>
        <!--header-->

        <div id="login" class="login_page d-flex" style="background-image: url(public/front/images/login-bg.jpg);">
            <div class="container align-self-center">
                <div class="row no-gutters justify-content-center">
                    <div class="login_form_wrapper">
                        <div class="form-heading-block text-center">
                            <h1 class="heading-title">Forgot Password</h1>
                        </div>
                        @if(Session::has('errors'))
                            <p class="wppb-warning">The email address entered wasn't found in the database! Please check that you entered the correct email address.</p>
                        @endif
                        <div id="login-wrap" class="login-user-forms">
                            <form enctype="multipart/form-data" method="post" id="recover-password" class="user-form" action="{{ route('password.email') }}">
                                @csrf
                                <p class="form-title">Please enter your username or email address.<br>You will receive a link to create a new password via email.</p>
                                <ul>
                                    <li class="form-field username-email">
                                        <input class="text-input" name="email" type="email" id="email" value="" placeholder="Username or E-mail" required>
                                    </li><!-- .email -->
                                </ul>
                                <p class="form-submit">
                                    <input name="recover_password" type="submit" id="recover-password-button" class="submit button" value="Get New Password">
                                </p>
                            </form>
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