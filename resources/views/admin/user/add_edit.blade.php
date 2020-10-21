@extends('admin-layouts.master')

@section('title', 'Users')

@section('breadcrumb')
	<li><a href="{{url(\Config::get('constants.ADMIN_URL').'user')}}">Users</a></li>
	<li class="active">{{isset($user) ? 'Edit' : 'Add'}} User</li>
@endsection

@section('section-add-more-button')
	<ul class="breadcrumb-elements">
		<li>
			<a href="{{url(\Config::get('constants.ADMIN_URL').'user')}}">
				<button class="btn btn-xs btn-primary btn-small mt5"><i class="icon-arrow-left13"></i> Back</button>
			</a>
		</li>
	</ul>
@endsection

@section('content')

	@php 
		$id = isset($user) ? '/'.$user->id : '';
	@endphp

	<form id="form_id_common" class="{{isset($user)?'edit':'add'}}" action="{{url(\Config::get('constants.ADMIN_URL'))}}/user{{$id}}" method="POST" enctype="multipart/form-data">
		@csrf
		@if(isset($user))
            {{method_field('PUT')}}
        @endif

		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">{{isset($user) ? 'Edit' : 'Add'}} User</h5>
			</div>

			<div class="panel-body">

				<legend class="border-primary text-primary text-bold">User Detail</legend>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Name : <span class="text-danger">*</span></label>
							<input type="text" name="name" class="form-control" placeholder="User Name" value="@if(old('name')){{old('name')}}@elseif(isset($user)){{$user->name}}@endif" maxlength="64" required>
							@error('name')
							    <label id="name-error" class="validation-error-label" for="name">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Email : <span class="text-danger">*</span></label>
							<input type="email" name="email" class="form-control" placeholder="Email" value="@if(old('email')){{old('email')}}@elseif(isset($user)){{$user->email}}@endif" maxlength="64" required>
							@error('email')
							    <label id="email-error" class="validation-error-label" for="email">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>
				<div class="row">
					@if(!isset($user))
						<div class="col-md-6">
							<div class="form-group">
								<label>Password : </label>
								<input type="password" name="password" class="form-control" placeholder="Password" value="@if(old('password')){{old('password')}}@elseif(isset($user)){{$user->password}}@endif" maxlength="255">
								@error('password')
								    <label id="password-error" class="validation-error-label" for="password">{{ $message }}</label>
								@enderror
							</div>							
						</div>
					@endif
					<div class="col-md-6">
						<div class="form-group">
							<label>User Type : <span class="text-danger">*</span></label>
							<select class="form-control simple_dropdown" id="user_type" name="user_type" required>
								<option value="">Select</option>
								@if(!empty(\Config::get('constants.USER_TYPE')))
		                            @foreach(\Config::get('constants.USER_TYPE') as $ut)
										@if(old('user_type') == $ut)
											<option value="{{$ut}}" selected>{{$ut}}</option>
										@elseif(@$user->user_type == $ut)
											<option value="{{$ut}}" selected>{{$ut}}</option>
										@else
											<option value="{{$ut}}">{{$ut}}</option>
										@endif
									@endforeach
								@endif
							</select>
							@error('user_type')
							    <label id="user_type-error" class="validation-error-label" for="user_type">{{ $message }}</label>
							@enderror
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-3 col-sm-4 col-md-2">
						<div class="form-group">
							<div class="thumbnail">
								@if(!empty($user->profile_image) && file_exists(storage_path().'/userProfilePicture/'.$user->profile_image))
							      	<a href="{{URL('').'/get_image/userProfilePicture/'.$user->profile_image}}">
							        	<img src="{{URL('').'/get_image/userProfilePicture/'.$user->profile_image}}" alt="User Profile Image" style="width:100%;  height: 130px;">
						        		<div style="padding: 5px; text-align: center;">
							          		<span>Profile Image</span>
						        		</div>
							      	</a>
								@else
						        	<img src="{{url('').'/public/image/user_avatar.png'}}" alt="User Profile Image" style="width:100%; height: 130px;">
					        		<div style="padding: 5px; text-align: center;">
						          		<span>Profile Image</span>
					        		</div>
								@endif
							</div>
						</div>
					</div>
					<div class="col-xs-9 col-sm-6 col-md-4">
						<div class="form-group">
							<label>Profile Picture : </label>
							<input type="file" name="profile_image" class="form-control" placeholder="Profile Picture" data-show-preview='false' data-show-caption='true' onchange="valid_image_upload()">
							@error('profile_image')
							    <label id="profile_image-error" class="validation-error-label" for="profile_image">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<br/>
				<div class="text-right">
					<button type="button" id="submit_btn_id_common" class="btn btn-xs btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
				</div>
			</div>
		</div>
	</form>

    <script type="text/javascript">
    	validateFormByFormId('form_id_common');
    </script>

@endsection