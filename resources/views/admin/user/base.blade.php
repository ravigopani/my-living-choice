@extends('admin-layouts.master')

@section('title', 'Users')

@section('breadcrumb')
	<li class="active">Users</li>
@endsection

@section('section-add-more-button')
	<ul class="breadcrumb-elements">
		<li>
			<a href="{{url(\Config::get('constants.ADMIN_URL').'user/create')}}"><button class="btn btn-xs btn-primary btn-small mt5"><i class="icon-plus2"></i> Add User</button></a>
		</li>
	</ul>
@endsection

@section('content')

	<div class="panel panel-flat" id="list_load">
    </div>

    <script type="text/javascript">
    	$(document).ready(function (){
	        ajaxLoad(ADMIN_URL+'list_user');
	    });

    	function user_list_load()
        {
            ajaxLoad(ADMIN_URL+'list_user?ok=1&search='+$('#search').val()+'&search_category='+$('#search_category').val()+'&search_size='+$('#search_size').val()+'&show='+$('#show').val());
        }
    </script>

@endsection