@extends('admin-layouts.master')

@section('title', 'Content Manage')

@section('breadcrumb')
	<li><a href="{{url(\Config::get('constants.ADMIN_URL').'content_manage')}}">Content Manage</a></li>
	<li class="active">Content Manage</li>
@endsection

@section('section-add-more-button')
	<ul class="breadcrumb-elements">
		<li>
			<a href="{{url(\Config::get('constants.ADMIN_URL').'content_manage')}}">
				<button class="btn btn-xs btn-primary btn-small mt5"><i class="icon-arrow-left13"></i> Back</button>
			</a>
		</li>
	</ul>
@endsection

@section('content')

	<form id="form_id_common" action="{{url(\Config::get('constants.ADMIN_URL'))}}/content_manage" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">Content Manage</h5>
			</div>

			<div class="panel-body">

				<legend class="border-primary text-primary text-bold">Content Manage Details</legend>

				<div class="row">
					<div class="col-xs-3 col-sm-4 col-md-2">
						<div class="form-group">
							<div class="thumbnail">
								@if(!empty($content_manage->website_logo) && file_exists(storage_path().'/userProfilePicture/'.$content_manage->website_logo))
							      	<a href="{{URL('').'/get_image/userProfilePicture/'.$content_manage->website_logo}}">
							        	<img src="{{URL('').'/get_image/userProfilePicture/'.$content_manage->website_logo}}" alt="User Profile Image" style="width:100%;  height: 130px;">
						        		<div style="padding: 5px; text-align: center;">
							          		<span>Website Logo</span>
						        		</div>
							      	</a>
								@else
						        	<img src="{{url('').'/public/image/user_avatar.png'}}" alt="User Profile Image" style="width:100%; height: 130px;">
					        		<div style="padding: 5px; text-align: center;">
						          		<span>Website Logo</span>
					        		</div>
								@endif
							</div>
						</div>
					</div>
					<div class="col-xs-9 col-sm-6 col-md-4">
						<div class="form-group">
							<label>Website Logo : </label>
							<input type="file" name="website_logo" class="form-control" placeholder="Profile Picture" data-show-preview='false' data-show-caption='true' onchange="valid_image_upload()">
							@error('website_logo')
							    <label id="website_logo-error" class="validation-error-label" for="website_logo">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Footer : </label>
							<input type="text" name="footer" class="form-control" placeholder="Footer" value="@if(old('footer')){{old('footer')}}@elseif(isset($content_manage)){{$content_manage->footer}}@endif" maxlength="64" required>
							@error('footer')
							    <label id="name-error" class="validation-error-label" for="name">{{ $message }}</label>
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