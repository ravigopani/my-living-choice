@extends('admin-layouts.master')

@section('title', 'Properties')

@section('breadcrumb')
	<li><a href="{{url(\Config::get('constants.ADMIN_URL').'property')}}">Properties</a></li>
	<li class="active">{{isset($property) ? 'Edit' : 'Add'}} Property</li>
@endsection

@section('section-add-more-button')
	<ul class="breadcrumb-elements">
		<li>
			<a href="{{url(\Config::get('constants.ADMIN_URL').'property')}}">
				<button class="btn btn-xs btn-primary btn-small mt5"><i class="icon-arrow-left13"></i> Back</button>
			</a>
		</li>
	</ul>
@endsection

@section('content')

	@php 
		$id = isset($property) ? '/'.$property->id : '';
		$checked_cares = [];

		if(!empty($id))
		{
	        if(!empty($property_cares)){
	        	foreach ($property_cares as $value) {
	        		$checked_cares[] =  $value['care_id'];
	        	}
	        }

			$per_field_value = 3.846;
			$bo_total = 11;
			$bo_count = 0;
			!empty($property->header_image) ? $bo_count++ : '';
			!empty($property->logo_image) ? $bo_count++ : '';
			!empty($property->name) ? $bo_count++ : '';
			!empty($property->website) ? $bo_count++ : '';
			!empty($property->owner_id) ? $bo_count++ : '';
			!empty($property->address) ? $bo_count++ : ''; 
			!empty($property->state_id) ? $bo_count++ : ''; 
			!empty($property->city_id) ? $bo_count++ : ''; 
			!empty($property->zip) ? $bo_count++ : ''; 
			!empty($property->latitude) ? $bo_count++ : ''; 
			!empty($property->longitude) ? $bo_count++ : '';
			$bo_per =  round($bo_count*$per_field_value);
			$bo_count = round(($bo_count * 100)/ $bo_total);

			$ci_total = 8;
			$ci_count = 0;
			!empty($property->phone_number) ? $ci_count++ : '';
			!empty($property->call_tracking_phone_number) ? $ci_count++ : '';
			!empty($property->contact_name) ? $ci_count++ : '';
			!empty($property->contact_email) ? $ci_count++ : '';
			!empty($property->facebook_link) ? $ci_count++ : '';
			!empty($property->linkedin_link) ? $ci_count++ : ''; 
			!empty($property->twitter_link) ? $ci_count++ : ''; 
			!empty($property->instagram_link) ? $ci_count++ : ''; 
			$ci_per =  round($ci_count*$per_field_value);
			$ci_count = round(($ci_count * 100)/ $ci_total);

			$bi_total = 3;
			$bi_count = 0;
			!empty($property->short_description) ? $bi_count++ : '';
			!empty($property->long_description) ? $bi_count++ : '';
			!empty($checked_cares) ? $bi_count++ : '';
			$bi_per =  round($bi_count*$per_field_value);
			$bi_count = round(($bi_count * 100)/ $bi_total);

			$pi_total = 4;
			$pi_count = 0;
			!empty($property->year_opened) ? $pi_count++ : '';
			!empty($property->starting_price) ? $pi_count++ : '';
			!empty($property->total_units) ? $pi_count++ : '';
			!empty(explode(',', @$property->amenities)) ? $pi_count++ : '';
			$pi_per =  round($pi_count*$per_field_value);
			$pi_count = round(($pi_count * 100)/ $pi_total);
			$not_filed = 100 - ($bo_per + $ci_per + $bi_per + $pi_per); 
		}

	@endphp

	<form id="form_id_common" class="{{isset($property)?'edit':'add'}}" action="{{url(\Config::get('constants.ADMIN_URL'))}}/property{{$id}}" method="POST" enctype="multipart/form-data">
		@csrf
		@if(isset($property))
            {{method_field('PUT')}}
        @endif

		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">{{isset($property) ? 'Edit' : 'Add'}} Property </h5>
			</div>

			<div class="panel-body">

				@if(isset($property))
				<legend class="border-primary text-primary text-bold">Profile Completion Score</legend>

				<div class="row">
					<div class="col-md-7">
						<canvas id="chart-area" style="max-height: 500px; max-width: 500px;"></canvas>
					</div>
					<div class="col-md-5" style="padding-top: 50px">
						<ul class="list-unstyled">
				            <li class="mb-10">
				                <div class="d-flex align-items-center mb-1">Business Overview <span class="text-muted ml-auto">{{$bo_count}}%</span></div>
								<div class="progress" style="height: 10px">
									<div class="progress-bar bg-info" style="width: {{$bo_count}}%">
										<span class="sr-only">{{$bo_count}}% Complete</span>
									</div>
								</div>
				            </li>

				            <li class="mb-10">
				                <div class="d-flex align-items-center mb-1">Contact Info <span class="text-muted ml-auto">{{$ci_count}}%</span></div>
								<div class="progress" style="height: 10px;">
									<div class="progress-bar bg-danger" style="width: {{$ci_count}}%">
										<span class="sr-only">{{$ci_count}}% Complete</span>
									</div>
								</div>
				            </li>

				            <li class="mb-10">
				                <div class="d-flex align-items-center mb-1">Business Info <span class="text-muted ml-auto">{{$bi_count}}%</span></div>
								<div class="progress" style="height: 10px;">
									<div class="progress-bar bg-success" style="width: {{$bi_count}}%">
										<span class="sr-only">{{$bi_count}}% Complete</span>
									</div>
								</div>
				            </li>

				            <li>
				                <div class="d-flex align-items-center mb-1">Property Info <span class="text-muted ml-auto">{{$pi_count}}%</span></div>
								<div class="progress" style="height: 10px;">
									<div class="progress-bar bg-orange-300" style="width: {{$pi_count}}%">
										<span class="sr-only">{{$pi_count}}% Complete</span>
									</div>
								</div>
				            </li>
				        </ul>
					</div>
				</div>
				@endif

				<legend class="border-primary text-primary text-bold">Business Overview</legend>

				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<div class="thumbnail">
								@if(!empty($property->header_image) && file_exists(storage_path().'/propertyImage/'.$property->header_image))
							      	<a href="{{URL('').'/get_image/propertyImage/'.$property->header_image}}">
							        	<img src="{{URL('').'/get_image/propertyImage/'.$property->header_image}}" alt="Header Image" style="width:100%;  height: 130px;">
						        		<div style="padding: 5px; text-align: center;">
							          		<span>Header Image</span>
						        		</div>
							      	</a>
								@else
						        	<img src="{{url('').'/public/image/no_img.png'}}" alt="Header Image" style="width:100%; height: 130px;">
					        		<div style="padding: 5px; text-align: center;">
						          		<span>Header Image</span>
					        		</div>
								@endif
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Header Image : </label>
							<input type="file" name="header_image" class="form-control" placeholder="Header Image" data-show-preview='false' data-show-caption='true'>
							@error('header_image')
							    <label id="header_image-error" class="validation-error-label" for="header_image">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<div class="thumbnail">
								@if(!empty($property->logo_image) && file_exists(storage_path().'/propertyImage/'.$property->logo_image))
							      	<a href="{{URL('').'/get_image/propertyImage/'.$property->logo_image}}">
							        	<img src="{{URL('').'/get_image/propertyImage/'.$property->logo_image}}" alt="Logo Image" style="width:100%;  height: 130px;">
						        		<div style="padding: 5px; text-align: center;">
							          		<span>Logo Image</span>
						        		</div>
							      	</a>
								@else
						        	<img src="{{url('').'/public/image/no_img.png'}}" alt="Logo Image" style="width:100%;  height: 130px;">
					        		<div style="padding: 5px; text-align: center;">
						          		<span>Logo Image</span>
					        		</div>
								@endif
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Logo Image : </label>
							<input type="file" name="logo_image" class="form-control" placeholder="Logo Image" data-show-preview='false' data-show-caption='true'>
							@error('logo_image')
							    <label id="logo_image-error" class="validation-error-label" for="logo_image">{{ $message }}</label>
							@enderror
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Property Name : <span class="text-danger">*</span></label>
							<input type="text" name="name" class="form-control" placeholder="Property Name" value="@if(old('name')){{old('name')}}@elseif(isset($property)){{$property->name}}@endif" maxlength="128" required>
							@error('name')
							    <label id="name-error" class="validation-error-label" for="name">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Website : </label>
							<input type="website" name="website" class="form-control" placeholder="Website" value="@if(old('website')){{old('website')}}@elseif(isset($property)){{$property->website}}@endif" maxlength="128">
							@error('website')
							    <label id="website-error" class="validation-error-label" for="website">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Property Owner : <span class="text-danger">*</span></label>
							<select class="form-control search_dropdown" id="owner_id" name="owner_id" required>
								<option value="">Select</option>
								@if(!empty($owners))
		                            @foreach($owners as $val)
										@if(old('owner_id') == $val->id)
											<option value="{{$val->id}}" selected>{{$val->name}}</option>
										@elseif(@$property->owner_id == $val->id)
											<option value="{{$val->id}}" selected>{{$val->name}}</option>
										@else
											<option value="{{$val->id}}">{{$val->name}}</option>
										@endif
									@endforeach
								@endif
							</select>
							@error('owner_id')
							    <label id="owner_id-error" class="validation-error-label" for="owner_id">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Search Location : </label>
							<input type="text" name="search_location" id="search_location" class="form-control" placeholder="Search Location">
							@error('search_location')
							    <label id="search_location-error" class="validation-error-label" for="search_location">{{ $message }}</label>
							@enderror
						</div>							
					</div>					
				</div>

				<div class="row form-group">
					<div class="col-md-12" id="map" style="height: 300px;">
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>State : </label>
							<select class="form-control search_dropdown state" id="state_id" name="state_id">
								<option value="">Select</option>
								@if(!empty($states))
		                            @foreach($states as $val)
										@if(old('state_id') == $val->id)
											<option value="{{$val->id}}" selected>{{$val->state}}</option>
										@elseif(@$property->state_id == $val->id)
											<option value="{{$val->id}}" selected>{{$val->state}}</option>
										@else
											<option value="{{$val->id}}">{{$val->state}}</option>
										@endif
									@endforeach
								@endif
							</select>
							@error('state_id')
							    <label id="state_id-error" class="validation-error-label" for="state_id">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>City : </label>
							<select class="form-control search_dropdown city" id="city_id" name="city_id">
								<option value="">Select</option>
								@if(!empty($cities))
		                            @foreach($cities as $val)
										@if(old('city_id') == $val->id)
											<option value="{{$val->id}}" selected>{{$val->city}}</option>
										@elseif(@$property->city_id == $val->id)
											<option value="{{$val->id}}" selected>{{$val->city}}</option>
										@else
											<option value="{{$val->id}}">{{$val->city}}</option>
										@endif
									@endforeach
								@endif
							</select>
							@error('city')
							    <label id="city-error" class="validation-error-label" for="city">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Zip Code : </label>
							<input type="zip" name="zip" class="form-control" placeholder="Zip Code" value="@if(old('zip')){{old('zip')}}@elseif(isset($property)){{$property->zip}}@endif" maxlength="10">
							@error('zip')
							    <label id="zip-error" class="validation-error-label" for="zip">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Address : <span class="text-danger">*</span></label>
							<input type="text" name="address" id="address" class="form-control" placeholder="Property Address" value="@if(old('address')){{old('address')}}@elseif(isset($property)){{$property->address}}@endif" maxlength="256" required>
							@error('address')
							    <label id="address-error" class="validation-error-label" for="address">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Latitude : <span class="text-danger">*</span></label>
							<input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" value="@if(old('latitude')){{old('latitude')}}@elseif(isset($property)){{$property->latitude}}@endif" maxlength="15" required>
							@error('latitude')
							    <label id="latitude-error" class="validation-error-label" for="latitude">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Longitude : <span class="text-danger">*</span></label>
							<input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude" value="@if(old('longitude')){{old('longitude')}}@elseif(isset($property)){{$property->longitude}}@endif" maxlength="15" required>
							@error('longitude')
							    <label id="longitude-error" class="validation-error-label" for="longitude">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				@if(isset($property))

				<legend class="border-primary text-primary text-bold" style="padding-bottom: 20px;">
					<span>Gallery</span>
					<button type="button" class="btn btn-xs btn-primary pull-right" onclick="add_photo(this);" data-property_id="{{$property->id}}"><i class="icon-plus2"></i> Add Photo</button>
				</legend>

				<div id="div_gallery">
	            	@php $count = 1; $tmp_start = false; @endphp
		            @if(!empty($property_gallery))
		                @foreach($property_gallery as $key=>$value)
		                    @if($count == 1 || $tmp_start)
		                        <div class="row">
		                        <div class="col-lg-3 col-sm-6">
		                            <div class="thumbnail">
		                                <div class="thumb">
		                                    @if(file_exists(storage_path().'/propertyGallery/'.$property->id.'/'.$value->file_path))
		                                        <img src="{{URL('').'/get_image/propertyGallery/'.$value->file_path.'/'.$property->id}}" alt="" class="max-height-gallery">
		                                        <div class="caption-overflow">
		                                            <span>
		                                                <a href="{{URL('').'/get_image/propertyGallery/'.$value->file_path.'/'.$property->id}}" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-enlarge"></i></a>
		                                                <a href="javascript:void(0);" onclick="delete_conf_common('{{$value->id}}','PropertyGallery','property_gallery','Gallery Image','div_gallery','TABLE');" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-trash"></i></a>
		                                            </span>
		                                        </div>
		                                    @else
		                                        <img src="{{URL::asset('public/image/no_image.jpg')}}" alt="" class="max-height-gallery">
		                                        <div class="caption-overflow">
		                                            <span>
		                                                <a href="{{URL::asset('public/image/no_image.jpg')}}" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-enlarge"></i></a>
		                                            </span>
		                                        </div>
		                                    @endif

		                                </div>
		                            </div>
		                        </div>    
		                        @if($count == sizeof($property_gallery)) </div> @endif
		                        @php $tmp_start = false;  @endphp
		                    @elseif($count%4 == 0)
		                        <div class="col-lg-3 col-sm-6">
		                            <div class="thumbnail">
		                                <div class="thumb">
		                                    @if(file_exists(storage_path().'/propertyGallery/'.$property->id.'/'.$value->file_path))
		                                        <img src="{{URL('').'/get_image/propertyGallery/'.$value->file_path.'/'.$property->id}}" alt="" class="max-height-gallery">
		                                        <div class="caption-overflow">
		                                            <span>
		                                                <a href="{{URL('').'/get_image/propertyGallery/'.$value->file_path.'/'.$property->id}}" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-enlarge"></i></a>
		                                                <a href="javascript:void(0);" onclick="delete_conf_common('{{$value->id}}','PropertyGallery','property_gallery','Gallery Image','div_gallery','TABLE');" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-trash"></i></a>
		                                            </span>
		                                        </div>
		                                    @else
		                                        <img src="{{URL::asset('public/image/no_image.jpg')}}" alt="" class="max-height-gallery">
		                                        <div class="caption-overflow">
		                                            <span>
		                                                <a href="{{URL::asset('public/image/no_image.jpg')}}" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-enlarge"></i></a>
		                                            </span>
		                                        </div>
		                                    @endif

		                                </div>
		                            </div>
		                        </div>
		                        </div>
		                        @php $tmp_start = true;  @endphp
		                    @else
		                        <div class="col-lg-3 col-sm-6">
		                            <div class="thumbnail">
		                                <div class="thumb">
		                                    @if(file_exists(storage_path().'/propertyGallery/'.$property->id.'/'.$value->file_path))
		                                        <img src="{{URL('').'/get_image/propertyGallery/'.$value->file_path.'/'.$property->id}}" alt="" class="max-height-gallery">
		                                        <div class="caption-overflow">
		                                            <span>
		                                                <a href="{{URL('').'/get_image/propertyGallery/'.$value->file_path.'/'.$property->id}}" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-enlarge"></i></a>
		                                                <a href="javascript:void(0);" onclick="delete_conf_common('{{$value->id}}','PropertyGallery','property_gallery','Gallery Image','div_gallery','TABLE');" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-trash"></i></a>
		                                            </span>
		                                        </div>
		                                    @else
		                                        <img src="{{URL::asset('public/image/no_image.jpg')}}" alt="" class="max-height-gallery">
		                                        <div class="caption-overflow">
		                                            <span>
		                                                <a href="{{URL::asset('public/image/no_image.jpg')}}" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-enlarge"></i></a>
		                                            </span>
		                                        </div>
		                                    @endif

		                                </div>
		                            </div>
		                        </div>
		                        @if($count == sizeof($property_gallery)) </div> @endif
		                        @php $tmp_start = false;  @endphp
		                    @endif
		                    @php $count++; @endphp
		                @endforeach
		            @else
		            	<h5 class="text-center">No Pictures uploaded.</h5>	
		            @endif
				</div>
				@endif

				<legend class="border-primary text-primary text-bold">Contact Info</legend>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Phone Number : <span class="text-danger">*</span></label>
							<input type="text" name="phone_number" class="form-control" placeholder="Phone Number" value="@if(old('phone_number')){{old('phone_number')}}@elseif(isset($property)){{$property->phone_number}}@endif" maxlength="15" required>
							@error('phone_number')
							    <label id="phone_number-error" class="validation-error-label" for="phone_number">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Call Tracking Phone Number : </label>
							<input type="call_tracking_phone_number" name="call_tracking_phone_number" class="form-control" placeholder="Call Tracking Phone Number" value="@if(old('call_tracking_phone_number')){{old('call_tracking_phone_number')}}@elseif(isset($property)){{$property->call_tracking_phone_number}}@endif" maxlength="15">
							@error('call_tracking_phone_number')
							    <label id="call_tracking_phone_number-error" class="validation-error-label" for="call_tracking_phone_number">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Contact Name : </label>
							<input type="text" name="contact_name" class="form-control" placeholder="Contact Name" value="@if(old('contact_name')){{old('contact_name')}}@elseif(isset($property)){{$property->contact_name}}@endif" maxlength="128">
							@error('contact_name')
							    <label id="contact_name-error" class="validation-error-label" for="contact_name">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Contact Email : </label>
							<input type="text" name="contact_email" class="form-control" placeholder="Contact Email" value="@if(old('contact_email')){{old('contact_email')}}@elseif(isset($property)){{$property->contact_email}}@endif" maxlength="128">
							@error('contact_email')
							    <label id="contact_email-error" class="validation-error-label" for="contact_email">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Facebook : </label>
							<input type="text" name="facebook_link" class="form-control" placeholder="Facebook Link" value="@if(old('facebook_link')){{old('facebook_link')}}@elseif(isset($property)){{$property->facebook_link}}@endif" maxlength="128">
							@error('facebook_link')
							    <label id="facebook_link-error" class="validation-error-label" for="facebook_link">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>LinkedIn : </label>
							<input type="text" name="linkedin_link" class="form-control" placeholder="LinkedIn Link" value="@if(old('linkedin_link')){{old('linkedin_link')}}@elseif(isset($property)){{$property->linkedin_link}}@endif" maxlength="128">
							@error('linkedin_link')
							    <label id="linkedin_link-error" class="validation-error-label" for="linkedin_link">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Twitter : </label>
							<input type="text" name="twitter_link" class="form-control" placeholder="Twitter Link" value="@if(old('twitter_link')){{old('twitter_link')}}@elseif(isset($property)){{$property->twitter_link}}@endif" maxlength="128">
							@error('twitter_link')
							    <label id="twitter_link-error" class="validation-error-label" for="twitter_link">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Instagram : </label>
							<input type="text" name="instagram_link" class="form-control" placeholder="Instagram Link" value="@if(old('instagram_link')){{old('instagram_link')}}@elseif(isset($property)){{$property->instagram_link}}@endif" maxlength="128">
							@error('instagram_link')
							    <label id="instagram_link-error" class="validation-error-label" for="instagram_link">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<legend class="border-primary text-primary text-bold">Business Info</legend>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Short Description : </label>
							<input type="text" name="short_description" class="form-control" placeholder="Short Description" value="@if(old('short_description')){{old('short_description')}}@elseif(isset($property)){{$property->short_description}}@endif" maxlength="512">
							@error('short_description')
							    <label id="short_description-error" class="validation-error-label" for="short_description">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label>Long Description : </label>
							<?php 
								echo '<textarea type="text" name="long_description" class="form-control" placeholder="Long Description" maxlength="64" rows="3">';
								echo old('short_description') ? old('short_description') : isset($property) ? $property->long_description : '';
								echo "</textarea>";
							?>
							@error('long_description')
							    <label id="long_description-error" class="validation-error-label" for="long_description">{{ $message }}</label>
							@enderror
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Types of Care : </label>
					</div>

					@if(!empty($cares))
						@foreach($cares as $val)
							<div class="col-md-3">
								<label class="form-check-label">
									<input type="checkbox" class="checkbox-primary" name="cares[]" value="{{$val->id}}" @if(in_array($val->id, $checked_cares)) checked @endif>
									<span style="margin-left: 5px; padding-top: 3px;">{{$val->care}}</span>
								</label>
							</div>
						@endforeach
					@else
					@endif
				</div>

				<legend class="border-primary text-primary text-bold mt10">Property Info</legend>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Year Opened : </label>
							<input type="text" name="year_opened" class="form-control" placeholder="Year Opened" value="@if(old('year_opened')){{old('year_opened')}}@elseif(isset($property)){{$property->year_opened}}@endif" maxlength="4">
							@error('year_opened')
							    <label id="year_opened-error" class="validation-error-label" for="year_opened">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Starting Price : </label>
							<input type="text" name="starting_price" class="form-control" placeholder="Starting Price" value="@if(old('starting_price')){{old('starting_price')}}@elseif(isset($property)){{$property->starting_price}}@endif">
							@error('starting_price')
							    <label id="starting_price-error" class="validation-error-label" for="starting_price">{{ $message }}</label>
							@enderror
						</div>							
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Total Units : </label>
							<input type="text" name="total_units" class="form-control" placeholder="Total Units" value="@if(old('total_units')){{old('total_units')}}@elseif(isset($property)){{$property->total_units}}@endif" maxlength="10">
							@error('total_units')
							    <label id="total_units-error" class="validation-error-label" for="total_units">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Amenties : </label>
					</div>

					@php
						$checked_amenities = explode(',', @$property->amenities);
					@endphp

					@if(!empty($amenities))
						@foreach($amenities as $val)
							<div class="col-md-3">
								<label class="form-check-label">
									<input type="checkbox" class="checkbox-primary" name="amenities[]" value="{{$val->id}}" @if(in_array($val->id, $checked_amenities)) checked @endif>
									<span style="margin-left: 5px; padding-top: 3px;">{{$val->amenity}}</span>
								</label>
							</div>
						@endforeach
					@else
					@endif
				</div>

				<legend class="border-primary text-primary text-bold">Manage Plans</legend>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Package : <span class="text-danger">*</span></label>
							<select class="form-control search_dropdown" id="package_id" name="package_id" required>
								<option value="">Select</option>
								@if(!empty($packages))
		                            @foreach($packages as $val)
										@if(old('package_id') == $val->id)
											<option value="{{$val->id}}" selected>{{$val->package}}</option>
										@elseif(@$property->package_id == $val->id)
											<option value="{{$val->id}}" selected>{{$val->package}}</option>
										@else
											<option value="{{$val->id}}">{{$val->package}}</option>
										@endif
									@endforeach
								@endif
							</select>
							@error('package_id')
							    <label id="package_id-error" class="validation-error-label" for="package_id">{{ $message }}</label>
							@enderror
						</div>							
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Show In List : </label>
					</div>
					<div class="col-md-3">
						<label class="form-check-label">
							<input type="checkbox" class="checkbox-primary" name="show_in_list" value="Yes" @if(old('show_in_list') == 'Yes') checked  @elseif(@$property->show_in_list == 'Yes') checked @endif >
							<span style="margin-left: 5px; padding-top: 3px;">Publish</span>
						</label>
					</div>
				</div>

				<br/>
				<div class="text-right">
					<button type="button" id="submit_btn_id_common" class="btn btn-xs btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
				</div>
			</div>
		</div>
	</form>

	<div id="modal_add_pic" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-cancel-square2 text-danger"></i></button>
                    <h5 class="modal-title">Picture</h5>
                </div>
                <form id="form_add_pic" class="form-validate-jquery" action="catalog" method="post">
                    <input type="hidden" id="property_id" name="property_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Upload File : <span class="text-danger" id="req_span_upfile">*</span></label>
                                    <input type="file" class="form-control" name="file_upload[]" id="file_upload" onchange="valid_image_upload()" required multiple>
                                </div>                          
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs bg-primary" id="submit_contact_detail" onclick="submit_photo()">
                            <i class="icon-checkmark3 position-left" style="font-size:11px"></i>
                            <span>Submit</span>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal">
                            <i class="icon-cross2 position-left" style="font-size:11px"></i>Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyB21RnJFbEed0ypqsqUSsQHukp_0LxgQuI"></script>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB21RnJFbEed0ypqsqUSsQHukp_0LxgQuI&callback=initMap&libraries=&v=weekly"
      defer></script>

    <script type="text/javascript">
    	/* FOR ADDRESS AUTOCOMPLETE - START */

    	const latitude = parseFloat('{{!empty($property->latitude) ? $property->latitude : 0}}');
    	const longitude = parseFloat('{{!empty($property->longitude) ? $property->longitude : 0}}');

    	var address = (document.getElementById('search_location'));
        var autocomplete = new google.maps.places.Autocomplete(address);
        autocomplete.setTypes(['geocode']);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }
	        // var address = '';
	        // if (place.address_components) {
	        //     address = [
	        //         (place.address_components[0] && place.address_components[0].short_name || ''),
	        //         (place.address_components[1] && place.address_components[1].short_name || ''),
	        //         (place.address_components[2] && place.address_components[2].short_name || '')
	        //         ].join(' ');
	        // }
	        $('#address').val(place.formatted_address);

	        geocoder = new google.maps.Geocoder();
		    var address = document.getElementById("search_location").value;
		    geocoder.geocode( { 'address': address}, function(results, status) {
			     if (status == google.maps.GeocoderStatus.OK) {
			      	$('#latitude').val(results[0].geometry.location.lat());
			      	$('#longitude').val(results[0].geometry.location.lng());
			     } 
			     else {
			        alert("Geocode was not successful for the following reason: " + status);
			     }
		     });
      	});
      	/* FOR ADDRESS AUTOCOMPLETE - END */

      	/* FOR MAP - START */
      	let map;
      	let markers = [];

      	console.log(latitude);
      	console.log(longitude);

      	function initMap() {
        	const haightAshbury = {
          		lat: latitude,
          		lng: longitude
    		};

	    	map = new google.maps.Map(document.getElementById("map"), {
	          	zoom: 12,
	          	center: haightAshbury,
	          	mapTypeId: "terrain"
	        }); // This event listener will call addMarker() when the map is clicked.

	        map.addListener("click", event => {
	          addMarker(event.latLng);
	        }); // Adds a marker at the center of the map.

	        addMarker(haightAshbury);
      	} // Adds a marker to the map and push to the array.

      	function addMarker(location) {
        	const marker = new google.maps.Marker({
          		position: location,
          		map: map
        	});
    		markers.push(marker);
      	}
      	/* FOR MAP - END */


    	validateFormByFormId('form_id_common');
    	$('.checkbox-primary').uniform({
            wrapperClass: 'border-primary text-primary'
        });

        function add_photo(obj)
        {
            $("#form_add_pic").validate().resetForm();
            $("#form_add_pic input,#form_add_pic select,#form_add_pic hidden,#form_add_pic textarea").val('');
            $("#form_add_pic #property_id").val($(obj).attr('data-property_id'));
            $('#modal_add_pic').modal('show');
        }

        function submit_photo()
        {
            if ($("#form_add_pic").valid()) 
            {
                var form_data = new FormData($('#form_add_pic')[0]);

                $.ajax({
                    type: "POST",
                    url: ADMIN_URL+'add_photo',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(data){
                        if(data.status == 'success')
                        {
                            show_notification(data.status,data.message);
                            $('#modal_add_pic').modal('hide');
                        }
                    },
                    error: function(e){
                        if(!isEmpty(e.responseJSON.errors)){
                            if(!isEmpty(e.responseJSON.errors.file_upload)){
                                show_notification('error',e.responseJSON.errors.file_upload[0]);
                            }
                        }
                        $('.loading').hide();
                    },
                    complete: function(e){
                        $('#div_gallery').load(location.href + ' #div_gallery');
                        $('.loading').hide();
                    }
                });
            }
        }

        var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						parseInt({{ !empty($bo_per) ? $bo_per : 0 }}),
						parseInt({{ !empty($ci_per) ? $ci_per : 0 }}),
						parseInt({{ !empty($bi_per) ? $bi_per : 0 }}),
						parseInt({{ !empty($pi_per) ? $pi_per : 0 }}),
						parseInt({{ !empty($not_filed) ? $not_filed : 0 }}),
					],
					backgroundColor: [
						window.chartColors.blue,
						window.chartColors.red,
						window.chartColors.green,
						window.chartColors.yellow,
						window.chartColors.grey,
					],
					label: ''
				}],
				labels: [
					'Business Overview',
					'Contact Info',
					'Business Info',
					'Property Info',
					'Not filled'
				]
			},
			options: {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: false,
					text: ''
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myDoughnut = new Chart(ctx, config);
		};

    </script>

    <style type="text/css">
    	.max-height-gallery{
    		max-height: 155px;
    	}
		canvas {
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}
    </style>

@endsection