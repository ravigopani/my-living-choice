@extends('admin-layouts.master')

@if(isset($career_detail)) 
    @section('title', 'Dashboard')
@else 
    @section('title', 'Dashboard')
@endif

@section('breadcrumb')
	<li class="active">Dashboard</li>
@endsection

@section('content')

	<div class="panel panel-flat">
		<div class="panel-heading">
			<h6 class="panel-title"></h6>
		</div>

		<div class="panel-body">
			<div class="content-group">
				<div class="row">
					<div class="col-md-12">
						<h2>Welcome to www.mylivingchoice.com</h2>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection