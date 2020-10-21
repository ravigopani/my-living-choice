@extends('admin-login-layouts.master')

@section('title', 'Register')

@section('navbar-link')
	<li>
		<a href="{{url('/admin/login')}}" title="Login">
			<i class="icon-user-check"></i>&nbsp;&nbsp;  Login
			{{-- <span class="visible-xs-inline-block position-right"> Register</span> --}}
		</a>
	</li>
@endsection

@section('content')

	<form method="POST" action="{{ route('register') }}">
       	@csrf
		<div class="panel panel-body login-form">
			<div class="text-center">
				<div class="icon-object border-success text-success"><i class="icon-user-plus"></i></div>
				<h5 class="content-group">Create company account 
					{{-- <small class="display-block">All fields are required</small> --}}
				</h5>
			</div>

			<div class="form-group has-feedback has-feedback-left">
				<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Company Name" required autofocus>
				<div class="form-control-feedback">
					<i class="icon-user text-muted"></i>
				</div>

				@if ($errors->has('name'))
	                <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $errors->first('name') }}</span>
	            @endif
			</div>

			<div class="form-group has-feedback has-feedback-left">
				<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Company Email" required>
				<div class="form-control-feedback">
					<i class="icon-mention text-muted"></i>
				</div>

				@if ($errors->has('email'))
	                <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $errors->first('email') }}</span>
	            @endif
			</div>

			<div class="form-group has-feedback has-feedback-left">
				<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Create password" required>
				<div class="form-control-feedback">
					<i class="icon-user-lock text-muted"></i>
				</div>

				@if ($errors->has('password'))
                    <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $errors->first('password') }}</span>
                @endif
			</div>

			<div class="form-group has-feedback has-feedback-left">
				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
				<div class="form-control-feedback">
					<i class="icon-user-lock text-muted"></i>
				</div>
			</div>

			<button type="submit" class="btn bg-teal btn-block btn-lg">Register <i class="icon-circle-right2 position-right"></i></button>
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