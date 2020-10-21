@extends('admin-layouts.master')

@section('title', 'Amenity')

@section('breadcrumb')
	<li class="active">Amenity</li>
@endsection

@section('section-add-more-button')
	<ul class="breadcrumb-elements">
		<li>
			<button class="btn btn-xs btn-primary btn-small mt5" onclick="add_amenity_modal();"><i class="icon-plus2"></i> Add Amenity</button>
		</li>
	</ul>
@endsection

@section('content')

	<div class="panel panel-flat" id="list_load">
    </div>

    {{-- <form id="delete-form" action="{{ url(\Config::get('constants.ADMIN_URL').'/amenties') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" value="delete">
        <input type="hidden" name="id" value="" id="delete_id">
    </form> --}}

    <div id="modal_add_amenity" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-cancel-square2 text-danger"></i></button>
                    <h5 class="modal-title" id="modal-title">Amenity</h5>
                </div>
                <form id="form_amenity" class="form-validate-jquery" action="amenity" method="post">
                    <input type="hidden" id="id" name="id" value="">
	                <div class="modal-body">
	                    <div class="row">
                            <div class="col-md-3">
                                <label>Amenity : <span class="text-danger">*</span></label>
                            </div>
							<div class="col-md-9">
								<div class="form-group">
                                    <input type="text" id="amenity" placeholder="Amenity" class="form-control" name="amenity" maxlength="128" required>
								</div>							
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-xs bg-primary" id="submit_contact_detail" onclick="add_edit_amenity()">
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
	        ajaxLoad(ADMIN_URL+'list_amenity');
	    });

    	function amenties_list_load()
        {
            ajaxLoad(ADMIN_URL+'list_amenity?ok=1&search='+$('#search').val()+'&search_category='+$('#search_category').val()+'&search_size='+$('#search_size').val()+'&show='+$('#show').val());
        }

        function add_amenity_modal()
		{
			$("#form_amenity").validate().resetForm();
			$("#form_amenity input,#form_amenity select,#form_amenity hidden").val('');
            $('#modal-title').html('Add Amenity');
		    $('#modal_add_amenity').modal('show');
            $(".search_dropdown").select2({ width: '100%',}).on("select2:close", function (e) {
                $(this).valid();
            });
		}

        function edit_amenity_modal(id)
        {
            $("#form_amenity").validate().resetForm();

            if (id != '') 
            {
                $.ajax({
                    type: "GET",
                    url: ADMIN_URL+"amenity/"+id+"/edit",
                    data:{
                    },
                    success: function(data){

                        if(!isEmpty(data.status) && data.status == 'error')
                        {
                            show_notification(data.status,data.message);
                            return false;
                        }

                        $('#modal_add_amenity #id').val(data.id);
                        $('#modal_add_amenity #amenity').val(data.amenity);
                        $('#modal-title').html('Edit Amenity');
                        $('#modal_add_amenity').modal('show');
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

        function add_edit_amenity()
        {
            if ($("#form_amenity").valid()) 
            {
                var form_data = $('#form_amenity').serialize();
                $.ajax({
                    type: "POST",
                    url: ADMIN_URL+'amenity',
                    data:form_data,
                    success: function(data){
                        if(data.status == 'success')
                        {
                            show_notification(data.status,data.message);
                            $('#modal_add_amenity').modal('hide');
                        }
                    },
                    error: function(e){
                        if(!isEmpty(e.responseJSON.errors)){
                            if(!isEmpty(e.responseJSON.errors.amenity)){
                                show_notification('error',e.responseJSON.errors.amenity[0]);
                            }
                        }
                    },
                    complete: function(e){
                        ajaxLoad('{{url(\Config::get('constants.ADMIN_URL').'list_amenity')}}');
                    }
                });
            }
        }

    </script>

@endsection