@extends('admin-login-layouts.master')

@section('title', 'Login')

@section('navbar-link')
	{{-- <li>
		<a href="{{url('/admin/register')}}" title="Register">
			<i class="icon-user-plus"></i>&nbsp;&nbsp;  Register
		</a>
	</li> --}}
@endsection

@section('content')

	<form method="POST" action="{{ route('login') }}">
        @csrf

		<div class="panel panel-body login-form">
			<div class="text-center">
				<div class="icon-object border-success text-success"><i class="icon-user-check"></i></div>
				<h5 class="content-group">Login to your account 
					{{-- <small class="display-block">Enter your credentials below</small> --}}
				</h5>
			</div>

			@if(Session::has('registered'))
				<div class="alert alert-success form-group">
					{{Session::get('registered')}}
	            </div>
	        @endif

			<div class="form-group has-feedback has-feedback-left">

				<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

				<div class="form-control-feedback">
					<i class="icon-mention text-muted"></i>
				</div>

				@if ($errors->has('email'))
                    <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $errors->first('email') }} </span>
                @endif

			</div>

			<div class="form-group has-feedback has-feedback-left">
				<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

				<div class="form-control-feedback">
					<i class="icon-lock2 text-muted"></i>
				</div>

				@if ($errors->has('password'))
					<span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $errors->first('password') }} </span>
                @endif

			</div>

			@if(Session::has('customer_captcha'))

			<div class="form-group has-feedback has-feedback-left row">
				<div id="div-captcha" class="col-md-8">
					@captcha
				</div>
				<div class="col-md-4" style="padding-top: 5px;">
					<a href="javascript:void(0);" id="regenerate_captcha" class="btn btn-primary btn-block" title="Re-generate Captcha"><i class="icon-rotate-cw3"></i></a>
				</div>
			</div>

			<div class="form-group has-feedback has-feedback-left">
				<input id="captcha" type="text" class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}" name="captcha" placeholder="Captcha" required maxlength="5">

				<div class="form-control-feedback">
					<i class="icon-image-compare text-muted"></i>
				</div>

				@if ($errors->has('captcha'))
					<span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $errors->first('captcha') }} </span>
                @endif

			</div>

			@endif

			<div class="form-group">
				<button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
			</div>

			@if (Route::has('password.request'))
	            <div class="text-center">
	            	<a href="{{ route('password.request') }}">Forgot password?</a>
	            </div>
	        @endif
		</div>
	</form>

@endsection

@section('footer-content')
	
	<script type="text/javascript">

		$.ajaxSetup({	//----------REDIRECT TO LOGIN PAGE IF SESSIONOUT DURING AJAX CALL-----------------------
            beforeSend:function(result){
                $(".loading").show();
            },
            complete: function(result){
                        $(".loading").hide();    
            },
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

		$(document).ready(function(){

			$('#regenerate_captcha').click(function(){
				$.ajax({
                    type: "POST",
                    url: BASE_URL+'refresh_captcha_image',
                    success: function (data) {
           				$('#div-captcha').html(data);
                    }
                });
			});

		});

	</script>
	
@endsection