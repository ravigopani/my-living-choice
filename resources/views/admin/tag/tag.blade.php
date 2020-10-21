@extends('admin-layouts.master')

@section('title', 'Tag')

@section('breadcrumb')
	<li class="active">Tag</li>
@endsection

@section('section-add-more-button')
	<ul class="breadcrumb-elements">
		<li>
			<button class="btn btn-xs btn-primary btn-small mt5" onclick="add_tag_modal();"><i class="icon-plus2"></i> Add Tag</button>
		</li>
	</ul>
@endsection

@section('content')

	<div class="panel panel-flat" id="list_load">
    </div>

    {{-- <form id="delete-form" action="{{ url(\Config::get('constants.ADMIN_URL').'/tags') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" value="delete">
        <input type="hidden" name="id" value="" id="delete_id">
    </form> --}}

    <div id="modal_add_tag" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-cancel-square2 text-danger"></i></button>
                    <h5 class="modal-title" id="modal-title">Tag</h5>
                </div>
                <form id="form_tag" class="form-validate-jquery" action="tag" method="post">
                    <input type="hidden" id="id" name="id" value="">
	                <div class="modal-body">
	                    <div class="row">
                            <div class="col-md-3">
                                <label>Tag : <span class="text-danger">*</span></label>
                            </div>
							<div class="col-md-9">
								<div class="form-group">
                                    <input type="text" id="tag" placeholder="Tag" class="form-control" name="tag" maxlength="128" required>
								</div>							
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-xs bg-primary" id="submit_contact_detail" onclick="add_edit_tag()">
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
	        ajaxLoad(ADMIN_URL+'list_tag');
	    });

    	function tags_list_load()
        {
            ajaxLoad(ADMIN_URL+'list_tag?ok=1&search='+$('#search').val()+'&search_category='+$('#search_category').val()+'&search_size='+$('#search_size').val()+'&show='+$('#show').val());
        }

        function add_tag_modal()
		{
			$("#form_tag").validate().resetForm();
			$("#form_tag input,#form_tag select,#form_tag hidden").val('');
		    $('#modal_add_tag').modal('show');
            $('#modal-title').html('Add Tag');
            $(".search_dropdown").select2({ width: '100%',}).on("select2:close", function (e) {
                $(this).valid();
            });
		}

        function edit_tag_modal(id)
        {
            $("#form_tag").validate().resetForm();

            if (id != '') 
            {
                $.ajax({
                    type: "GET",
                    url: ADMIN_URL+"tag/"+id+"/edit",
                    data:{
                    },
                    success: function(data){

                        if(!isEmpty(data.status) && data.status == 'error')
                        {
                            show_notification(data.status,data.message);
                            return false;
                        }

                        $('#modal_add_tag #id').val(data.id);
                        $('#modal_add_tag #tag').val(data.tag);
                        $('#modal-title').html('Edit Tag');
                        $('#modal_add_tag').modal('show');
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

        function add_edit_tag()
        {
            if ($("#form_tag").valid()) 
            {
                var form_data = $('#form_tag').serialize();
                $.ajax({
                    type: "POST",
                    url: ADMIN_URL+'tag',
                    data:form_data,
                    success: function(data){
                        if(data.status == 'success')
                        {
                            show_notification(data.status,data.message);
                            $('#modal_add_tag').modal('hide');
                        }
                    },
                    error: function(e){
                        if(!isEmpty(e.responseJSON.errors)){
                            if(!isEmpty(e.responseJSON.errors.tag)){
                                show_notification('error',e.responseJSON.errors.tag[0]);
                            }
                        }
                    },
                    complete: function(e){
                        ajaxLoad('{{url(\Config::get('constants.ADMIN_URL').'list_tag')}}');
                    }
                });
            }
        }

    </script>

@endsection