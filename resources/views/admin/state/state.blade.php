@extends('admin-layouts.master')

@section('title', 'State')

@section('breadcrumb')
	<li class="active">State</li>
@endsection

@section('section-add-more-button')
	<ul class="breadcrumb-elements">
		<li>
			<button class="btn btn-xs btn-primary btn-small mt5" onclick="add_state_modal();"><i class="icon-plus2"></i> Add State</button>
		</li>
	</ul>
@endsection

@section('content')

	<div class="panel panel-flat" id="list_load">
    </div>

    <div id="modal_add_state" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-cancel-square2 text-danger"></i></button>
                    <h5 class="modal-title" id="modal-title">State</h5>
                </div>
                <form id="form_state" class="form-validate-jquery" action="state" method="post">
                    <input type="hidden" id="id" name="id" value="">
	                <div class="modal-body">
	                    <div class="row">
                            <div class="col-md-3">
                                <label>State : <span class="text-danger">*</span></label>
                            </div>
							<div class="col-md-9">
								<div class="form-group">
                                    <input type="text" id="state" placeholder="State" class="form-control" name="state" maxlength="128" required>
								</div>							
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-xs bg-primary" id="submit_contact_detail" onclick="add_edit_state()">
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
	        ajaxLoad(ADMIN_URL+'list_state');
	    });

    	function states_list_load()
        {
            ajaxLoad(ADMIN_URL+'list_state?ok=1&search='+$('#search').val()+'&search_category='+$('#search_category').val()+'&search_size='+$('#search_size').val()+'&show='+$('#show').val());
        }

        function add_state_modal()
		{
			$("#form_state").validate().resetForm();
			$("#form_state input,#form_state select,#form_state hidden").val('');
            $('#modal-title').html('Add State');
		    $('#modal_add_state').modal('show');
            $(".search_dropdown").select2({ width: '100%',}).on("select2:close", function (e) {
                $(this).valid();
            });
		}

        function edit_state_modal(id)
        {
            $("#form_state").validate().resetForm();

            if (id != '') 
            {
                $.ajax({
                    type: "GET",
                    url: ADMIN_URL+"state/"+id+"/edit",
                    data:{
                    },
                    success: function(data){

                        if(!isEmpty(data.status) && data.status == 'error')
                        {
                            show_notification(data.status,data.message);
                            return false;
                        }

                        $('#modal_add_state #id').val(data.id);
                        $('#modal_add_state #state').val(data.state);
                        $('#modal-title').html('Edit State');
                        $('#modal_add_state').modal('show');
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

        function add_edit_state()
        {
            if ($("#form_state").valid()) 
            {
                var form_data = $('#form_state').serialize();
                $.ajax({
                    type: "POST",
                    url: ADMIN_URL+'state',
                    data:form_data,
                    success: function(data){
                        if(data.status == 'success')
                        {
                            show_notification(data.status,data.message);
                            $('#modal_add_state').modal('hide');
                        }
                    },
                    error: function(e){
                        if(!isEmpty(e.responseJSON.errors)){
                            if(!isEmpty(e.responseJSON.errors.state)){
                                show_notification('error',e.responseJSON.errors.state[0]);
                            }
                        }
                    },
                    complete: function(e){
                        ajaxLoad('{{url(\Config::get('constants.ADMIN_URL').'list_state')}}');
                    }
                });
            }
        }

    </script>

@endsection