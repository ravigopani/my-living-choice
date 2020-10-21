@extends('admin-login-layouts.master')

@section('title', 'Register')

@section('navbar-link')
@endsection

@section('content')

	<form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{$token}}">

		<div class="panel panel-body login-form">
			<div class="text-center">
				<div class="icon-object border-success text-success"><i class="icon-loop3"></i></div>
				<h5 class="content-group">Reset Password
					{{-- <small class="display-block">All fields are required</small> --}}
				</h5>
			</div>

			<div class="form-group has-feedback has-feedback-left">
				<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required>
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

			<button type="submit" class="btn bg-teal btn-block btn-lg">Reset Password <i class="icon-circle-right2 position-right"></i></button>
		</div>
	</form>

@endsection