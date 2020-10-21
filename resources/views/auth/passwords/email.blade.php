@extends('admin-login-layouts.master')

@section('title', 'Send Reset Password Email')

@section('navbar-link')
	<li>
		<a href="{{url('/admin/login')}}" title="Login">
			<i class="icon-user-check"></i>&nbsp;&nbsp;  Login
			{{-- <span class="visible-xs-inline-block position-right"> Register</span> --}}
		</a>
	</li>
	<li>
		<a href="{{url('/admin/register')}}" title="Register">
			<i class="icon-user-plus"></i>&nbsp;&nbsp;  Register
		</a>
	</li>
@endsection

@section('content')

	<form method="POST" action="{{ route('password.email') }}">
        @csrf
		<div class="panel panel-body login-form">
			<div class="text-center">
				<div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
				<h5 class="content-group">Password recovery <small class="display-block">We'll send you instructions in email</small></h5>
			</div>

			<div class="form-group has-feedback">
				
				<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>

				<div class="form-control-feedback">
					<i class="icon-mail5 text-muted"></i>
				</div>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

			</div>

			<button type="submit" class="btn bg-blue btn-block">Send Password Reset Link <i class="icon-arrow-right14 position-right"></i></button>
		</div>
	</form>

@endsection