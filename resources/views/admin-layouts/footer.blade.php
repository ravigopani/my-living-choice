<div class="footer text-muted">
	{{-- &copy; 2019. <a href="#">Ceramicwala</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Ravi Gopani</a> --}}
    ©2020 My Living Choice | All Rights Reserved <br/>
    TERMS OF SERVICE | PRIVACY POLICY
</div>

<div class="modal" data-backdrop="static" id="delete_confirm">
    <div class="modal-dialog modal-xs border-slate-800">
        <div class="modal-content border-slate border-lg4">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-cross2" style="color:white"></i></button>
                <h5 class="modal-title ">
                    <span class="module_action">Delete</span> Confirmation
                </h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <span class='module_action'>Delete</span> this <span id="module_title"></span>?</p><br>
				<div style="width: 100%;" class="text-center">                   
                    <button type="button" class="btn btn-xs bg-danger-800" id="delete-btn">
                    <i class="icon-bin position-left" style="font-size:11px"></i>
                        <span class="module_action">Delete</span>
                    </button>&nbsp;
                    <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">
                        <i class="icon-cross2 position-left" style="font-size:11px"></i>Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function(){
    //----------TOOL TIP-------
    // $('[data-popup=tooltip]').tooltip({
    //     template: '<div class="tooltip"><div class="bg-teal"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div></div>'
    // });
});

</script>