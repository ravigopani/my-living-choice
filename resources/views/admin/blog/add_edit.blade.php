@extends('admin-layouts.master')

@section('title', 'Blogs')

@section('breadcrumb')
	<li><a href="{{url(\Config::get('constants.ADMIN_URL').'blog')}}">Blogs</a></li>
	<li class="active">{{isset($blog) ? 'Edit' : 'Add'}} Blog</li>
@endsection

@section('section-add-more-button')
	<ul class="breadcrumb-elements">
		<li>
			<a href="{{url(\Config::get('constants.ADMIN_URL').'blog')}}">
				<button class="btn btn-xs btn-primary btn-small mt5"><i class="icon-arrow-left13"></i> Back</button>
			</a>
		</li>
	</ul>
@endsection

@section('content')

	@php 
		$id = isset($blog) ? '/'.$blog->id : '';
	@endphp

	<form id="form_id_common" class="{{isset($blog)?'edit':'add'}}" action="{{url(\Config::get('constants.ADMIN_URL'))}}/blog{{$id}}" method="POST" enctype="multipart/form-data">
		@csrf
		@if(isset($blog))
            {{method_field('PUT')}}
        @endif

		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">{{isset($blog) ? 'Edit' : 'Add'}} Blog</h5>
			</div>

			<div class="panel-body">

				<legend class="border-primary text-primary text-bold">Blog Detail</legend>

				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Title : <span class="text-danger">*</span></label>
									<input type="text" name="title" class="form-control" placeholder="Blog Title" value="@if(old('title')){{old('title')}}@elseif(isset($blog)){{$blog->title}}@endif" maxlength="64" required>
									@error('title')
									    <label id="title-error" class="validation-error-label" for="title">{{ $message }}</label>
									@enderror
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-4">
								<div class="form-group">
									<div class="thumbnail">
										@if(!empty($blog->image) && file_exists(storage_path().'/blogPicture/'.$blog->image))
									      	<a href="{{URL('').'/get_image/blogPicture/'.$blog->image}}">
									        	<img src="{{URL('').'/get_image/blogPicture/'.$blog->image}}" alt="Blog Blog Image" style="width:100%;  height: 130px;">
								        		<div style="padding: 5px; text-align: center;">
									          		<span>Blog Image</span>
								        		</div>
									      	</a>
										@else
								        	<img src="{{url('').'/public/image/no_image.jpg'}}" alt="Blog Blog Image" style="width:100%; height: 130px;">
							        		<div style="padding: 5px; text-align: center;">
								          		<span>Blog Image</span>
							        		</div>
										@endif
									</div>
								</div>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-8">
								<div class="form-group">
									<label>Blog Picture : </label>
									<input type="file" name="image" class="form-control" placeholder="Blog Picture" data-show-preview='false' data-show-caption='true' onchange="valid_image_upload()">
									@error('image')
									    <label id="image-error" class="validation-error-label" for="image">{{ $message }}</label>
									@enderror
								</div>							
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Short Description : <span class="text-danger">*</span></label>
							<?php 
								echo '<textarea type="text" name="short_description" class="form-control" placeholder="Short Description" rows="8">';
								echo old('short_description') ? old('short_description') : isset($blog) ? $blog->short_description : '';
								echo "</textarea>";
							?>
							@error('short_description')
							    <label id="short_description-error" class="validation-error-label" for="short_description">{{ $message }}</label>
							@enderror
						</div>									
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<?php 
							echo '<textarea type="text" id="editor" name="long_description" class="form-control" placeholder="Long Description" rows="8">';
							echo old('long_description') ? old('long_description') : isset($blog) ? $blog->long_description : '';
							echo "</textarea>";
						?>
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

    	ClassicEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
    </script>

@endsection