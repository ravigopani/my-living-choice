@extends('admin-layouts.master')

@section('title', 'Profile Edit')

@section('breadcrumb')
	<li class="active"> Profile Edit</li>
@endsection

@section('section-add-more-button')
	<ul class="breadcrumb-elements">
		<li>
			<a href="{{url(\Config::get('constants.ADMIN_URL'))}}">
				<button class="btn btn-xs btn-primary btn-small mt5"><i class="icon-arrow-left13"></i> Back</button>
			</a>
		</li>
	</ul>
@endsection

@section('content')

	<form id="form_id_common" action="{{url(\Config::get('constants.ADMIN_URL'))}}/profile_update" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">Profile Edit</h5>
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
					<div class="col-md-6">
						<div class="form-group">
							<label>Password : </label>
							<input type="password" name="password" class="form-control" placeholder="Password" maxlength="255">
							@error('password')
							    <label id="password-error" class="validation-error-label" for="password">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Confirm Password : </label>
							<input type="password" name="password_confirmation" class="form-control" placeholder="Password" maxlength="255">
							@error('password_confirmation')
							    <label id="password_confirmation-error" class="validation-error-label" for="password_confirmation">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="form-group" id="pswd_info" style="display: none; margin-top: 10px;">
	                    <div style="border: solid 1px #ccc;border-radius: 10px; padding-top: 5px; padding-left: 10px !important;">
	                        <span style="margin-top: 15px; font-size: 17px;">&nbsp;Password must meet the following formats:</span>
	                        <ul style="padding-left: 10px !important;">
	                            <li id="capital" class="pwd-validation-invalid"> <i class="icon-cross2"></i> At least <strong>one capital letter</strong></li>
	                            <li id="number" class="pwd-validation-invalid"> <i class="icon-cross2"></i> At least <strong>one number</strong></li>
	                            <li id="symbol" class="pwd-validation-invalid"> <i class="icon-cross2"></i> At least <strong>special character(!@#$%&*%)</strong></li>
	                            <li id="length" class="pwd-validation-invalid"> <i class="icon-cross2"></i> Be at least <strong>6 characters</strong></li>
	                            <li id="match" class="pwd-validation-invalid"> <i class="icon-cross2"></i> Password and confirm password <strong>must match.</strong></li>
	                        </ul>
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
					<button type="button" id="submit_btn_id" class="btn btn-xs btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
				</div>
			</div>
		</div>
	</form>

    <script type="text/javascript">

    	var startItems = convertSerializedArrayToHash($('#form_id_common').serializeArray());
    	$(document).on('click', '#submit_btn_id', function(e) {
		    var form_obj = $(this).closest('form');
		    var currentItems = convertSerializedArrayToHash($('#form_id_common').serializeArray());
	        var itemsToSubmit = hashDiff( startItems, currentItems);
	        itemsToSubmit = JSON.stringify(itemsToSubmit);
	        itemsToSubmit = itemsToSubmit.replace("{}", "");
	        if(Object.keys(itemsToSubmit).length != 0 || global_file_change_check || $('#form_id_common').hasClass('add'))
	        {
	        	if(!isEmpty( $('input[name="password"]').val() ) || !isEmpty( $('input[name="password_confirmation"]').val() ) )
			    {
			    	if(form_obj.valid() && c1 && c2 && c3 && c4 && c5 && c6)
				    {
				        form_obj.submit();
				    }
			    }
			    else if(form_obj.valid())
			    {
			        form_obj.submit();
			    }
	        }
	        else
	        {
	            show_notification('warning','No change to save.');
	            return false;
	        }
		    
		});

		$('input[name="password"],input[name="password_confirmation"]').keyup(function() { 
		    var pswd = $(this).val();       
		    c1 = c2 = c3 = c4 = c5 = c6 = false;
		    //validate the length
		    if ( pswd.length < 6 ) {
		        invalidPwd('length');
		        c1 = false;
		    } else {
		        validPwd('length');
		        c1 = true;
		    }       
		    //validate letter
		    if ( pswd.match(/[A-z]/) ) {
		        validPwd('letter');
		        c2 = true;
		    } else {
		        invalidPwd('letter');
		        c2 = false;
		    }       
		    //validate uppercase letter
		    if ( pswd.match(/[A-Z]/) ) {
		        validPwd('capital');
		        c3 = true;
		    } else {
		        invalidPwd('capital');
		        c3 = false;
		    }       
		    //validate number
		    if ( pswd.match(/\d/) ) {
		        validPwd('number');
		        c4 = true;
		    } else {
		        invalidPwd('number');
		        c4 = false;
		    }       
		    //validate symbol
		    //var re = /[!"\[\]{}%^&*:@~#';/.<>\\|`]/g;
		    if ( pswd.match (/[!@#$%&*%]/)) {
		        validPwd('symbol');
		        c5 = true;
		    } else {
		        invalidPwd('symbol');
		        c5 = false;
		    }       
		    //validate match
		    if ( ($("input[name='password']").val()==$("input[name='password_confirmation']").val()) && pswd!=''  ) {
		        validPwd('match');
		        c6 = true;
		    } else {
		        invalidPwd('match');
		        c6 = false;
		    }      
		}).focus(function() {
		    $('#pswd_info').show();
		});

		$("input[name='email'], input[name='old_password']").focus(function() {
		    $('#pswd_info').hide(); 
		});

		function invalidPwd(id)
		{
		    $('#'+id).removeClass('pwd-validation-valid').addClass('pwd-validation-invalid').find('i').removeClass('icon-checkmark3').addClass('icon-cross2');
		}

		function validPwd(id)
		{
		    $('#'+id).removeClass('pwd-validation-invalid').addClass('pwd-validation-valid').find('i').removeClass('icon-cross2').addClass('icon-checkmark3');
		}

    	validateFormByFormId('form_id_common');
    </script>

    <style type="text/css">
    	.pwd-validation-invalid {
		    line-height: 24px;
		    color: #ec3f41;
		    list-style-type: none;
		}
		.pwd-validation-valid {
		    line-height: 24px;
		    color: #00df00;
		    list-style-type: none;
		}
    </style>

@endsection