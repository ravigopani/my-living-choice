@extends('admin-layouts.master')

@section('title', 'City')

@section('breadcrumb')
	<li class="active">City</li>
@endsection

@section('section-add-more-button')
	<ul class="breadcrumb-elements">
		<li>
			<button class="btn btn-xs btn-primary btn-small mt5" onclick="add_city_modal();"><i class="icon-plus2"></i> Add City</button>
		</li>
	</ul>
@endsection

@section('content')

	<div class="panel panel-flat" id="list_load">
    </div>

    {{-- <form id="delete-form" action="{{ url(\Config::get('constants.ADMIN_URL').'/cities') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" value="delete">
        <input type="hidden" name="id" value="" id="delete_id">
    </form> --}}

    <div id="modal_add_city" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-cancel-square2 text-danger"></i></button>
                    <h5 class="modal-title" id="modal-title">City</h5>
                </div>
                <form id="form_city" class="form-validate-jquery" action="city" method="post">
                    <input type="hidden" id="id" name="id" value="">
	                <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>State : <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control search_dropdown" name="state_id" id="state_id" required>
                                    <option value="">Select State</option>
                                    @if(!empty($states))
                                        @foreach($states as $val)
                                            <option value="{{$val->id}}">{{$val->state}}</option>
                                        @endforeach
                                    @endif
                                </select>                  
                            </div>
                        </div>
	                    <div class="row form-group">
                            <div class="col-md-3">
                                <label>City : <span class="text-danger">*</span></label>
                            </div>
							<div class="col-md-9">
								<div class="form-group">
                                    <input type="text" id="city" placeholder="City" class="form-control" name="city" maxlength="128" required>
								</div>							
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-xs bg-primary" id="submit_contact_detail" onclick="add_edit_city()">
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

    <script type="text/javascript">

    	$(document).ready(function (){
	        ajaxLoad(ADMIN_URL+'list_city');
	    });

    	function cities_list_load()
        {
            ajaxLoad(ADMIN_URL+'list_city?ok=1&search='+$('#search').val()+'&search_category='+$('#search_category').val()+'&search_size='+$('#search_size').val()+'&show='+$('#show').val());
        }

        function add_city_modal()
		{
			$("#form_city").validate().resetForm();
			$("#form_city input,#form_city select,#form_city hidden").val('');
            $('#modal-title').html('Add City');
		    $('#modal_add_city').modal('show');
            $(".search_dropdown").select2({ width: '100%',}).on("select2:close", function (e) {
                $(this).valid();
            });
		}

        function edit_city_modal(id)
        {
            $("#form_city").validate().resetForm();

            if (id != '') 
            {
                $.ajax({
                    type: "GET",
                    url: ADMIN_URL+"city/"+id+"/edit",
                    data:{
                    },
                    success: function(data){

                        if(!isEmpty(data.status) && data.status == 'error')
                        {
                            show_notification(data.status,data.message);
                            return false;
                        }

                        $('#modal_add_city #id').val(data.id);
                        $('#modal_add_city #city').val(data.city);
                        $('#modal_add_city #state_id').val(data.state_id);
                        $('#modal-title').html('Edit City');
                        $('#modal_add_city').modal('show');
                        $(".search_dropdown").select2({ width: '100%',}).on("select2:close", function (e) {
                                $(this).valid();
                        });
                    },
                    error: function(e){
                        console.log(e);
                    }
                });
            }
            else
            {
                show_notification('error','Something went wrong.');
            }
        }

        function add_edit_city()
        {
            if ($("#form_city").valid()) 
            {
                var form_data = $('#form_city').serialize();
                $.ajax({
                    type: "POST",
                    url: ADMIN_URL+'city',
                    data:form_data,
                    success: function(data){
                        if(data.status == 'success')
                        {
                            show_notification(data.status,data.message);
                            $('#modal_add_city').modal('hide');
                        }
                    },
                    error: function(e){
                        if(!isEmpty(e.responseJSON.errors)){
                            if(!isEmpty(e.responseJSON.errors.city)){
                                show_notification('error',e.responseJSON.errors.city[0]);
                            }
                        }
                    },
                    complete: function(e){
                        ajaxLoad('{{url(\Config::get('constants.ADMIN_URL').'list_city')}}');
                    }
                });
            }
        }

    </script>

@endsection