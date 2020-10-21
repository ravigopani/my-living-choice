$(function(){

    // AJAX setup for common ajax call
    $.ajaxSetup({
        beforeSend:function(result) {
                $(".loading").show();
            },
        complete: function(result) {
                if(result.responseText == '{"error":"Unauthenticated."}'){
                        window.location.href = "login";         
                }
                $(".loading").hide();    
            },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Form Validate with class name
    var validator = $(".form-validate-jquery , .steps-validation").validate({
        ignore: [],
        errorClass: 'validation-error-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().removeClass('validate_tr');
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {
            
            // Styled checkboxes, radios, bootstrap switch
             if (element.hasClass('multiselect')) {
                    error.insertAfter(element.next('.btn-group'));
                }
            else if ( element.hasClass('colorpicker')) {
                    error.insertAfter(element.next('.sp-replacer'));
                    
                }    
            else if ( element.hasClass('file-input_control')) {
                error.appendTo( element.parent().parent().parent().parent());
            }    
        
            else if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline') ) {
                        error.appendTo( element.parent().parent().parent().parent() );
                }
                else {
                       
                    if(element.hasClass("use_type_radio"))
                    {
                        error.insertAfter( element.parent().parent().parent() );
                    }
                    else if(element.hasClass("lettergroup"))
                    {
                        error.insertAfter( element.parent().parent() );
                        
                    }
                    else if(element.hasClass("fuel_typegroup"))
                    {
                        error.appendTo( element.parent().parent().parent());
                    }
                    else
                    {
                        error.insertBefore( element.parent().parent().parent().parent().parent());
                    }
                }
            }
            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                if(element.parents('table').hasClass('validate_table') )
                {
                    element.parent().addClass('validate_tr');
                }
                else
                {
                    error.appendTo( element.parent() );
                }
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
                
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }
            else if(element.parents('table').hasClass('validate_table') )
            {
                element.parent().addClass('validate_tr');
              //  alert('add validate_tr');
            }
            else {
                
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        rules: {
            password: {
                minlength: 5
            },
            repeat_password: {
                equalTo: "#password"
            },
            email: {
                email: true
            },
            repeat_email: {
                equalTo: "#email"
            },
            minimum_characters: {
                minlength: 10
            },
            maximum_characters: {
                maxlength: 10
            },
            minimum_number: {
                min: 10
            },
            maximum_number: {
                max: 10
            },
            number_range: {
                range: [10, 20]
            },
            url: {
                url: true
            },
            date: {
                date: true
            },
            date_iso: {
                dateISO: true
            },
            numbers: {
                number: true
            },
            digits: {
                digits: true
            },
            creditcard: {
                creditcard: true
            },
            basic_checkbox: {
                minlength: 2
            },
            styled_checkbox: {
                minlength: 2
            },
            switchery_group: {
                minlength: 2
            },
            switch_group: {
                minlength: 2
            },
            planner_weekly_required:{
                    planner_weekly_required:true
            },
            planner_weekly_duplicate:{
                    planner_weekly_duplicate:true
            }
        },
        messages: {
            custom: {
                required: "This is a custom error message",
            },
            agree: "Please accept our policy"
        }
    });

    // masking for mobile number
    $(".mo_no_mask").mask("99999 99999");
    

    $(".search_dropdown").select2({ width: '100%',}).on("select2:close", function (e) {
            $(this).valid();
    });
    $(".search_dropdown").select2({ width: '100%',}).on("select2:open", function (e) {
        setTimeout(function(){
            $('.select2-dropdown').css('width','200px !important');
        },500);
    });
    $(".simple_dropdown").select2({ width: '100%',minimumResultsForSearch: -1,height: '10px'}).on("select2:close", function (e) {
        $(this).valid();
    });
    $(".half_simple_dropdown").select2({ width: '50%',minimumResultsForSearch: -1}).on("select2:close", function (e) {
        $(this).valid();
    });

    $('input[type=file]').on('change',function(){
        global_file_change_check = true;
    })

    var startItems = convertSerializedArrayToHash($('#form_id_common').serializeArray());
    $('#submit_btn_id_common').click(function(){
        var currentItems = convertSerializedArrayToHash($('#form_id_common').serializeArray());
        var itemsToSubmit = hashDiff( startItems, currentItems);
        itemsToSubmit = JSON.stringify(itemsToSubmit);
        itemsToSubmit = itemsToSubmit.replace("{}", "");
        if(Object.keys(itemsToSubmit).length != 0 || global_file_change_check || $('#form_id_common').hasClass('add'))
        {
            $(this).closest('form').submit();
        }
        else
        {
            show_notification('warning','No change to save.');
        }
    });

    $('.state').on('change',function(){
        var state = $(this).val();
        if(state)
        {
            $(".loading").show();
            $.ajax({
                type: "POST", 
                url: BASE_URL+'get_city_by_state',  // no base url required filename is includes baseurl.
                data: {
                    state:state
                },
                success: function (data) {
                    if(data.status == 'error')
                    {
                        show_notification(data.status,data.message);
                    }
                    else
                    {
                        $('.city').html(data);
                    }
                },
                error: function (xhr, status, error) {
                    alert("Whoops, looks like something went wrong");
                },
                complete:function(result){
                    $(".search_dropdown").select2({ width: '100%',}).on("select2:close", function (e) {
                            $(this).valid();
                    });
                    $(".loading").hide();           
                }
            });
        }
        else
        {
            $('.city').html('<select value="">select</select>');
        }
    });

});


// form validate by call this function by passing form name
function validateFormByFormId(formId){
    
    var FuncValidator = $('#'+formId).validate({
        ignore: [],
        errorClass: 'validation-error-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
            $(element).parent().removeClass('validate_tr');
        },
        // Different components require proper error label placement
        errorPlacement: function(error, element) {
            
            // Styled checkboxes, radios, bootstrap switch
             if (element.hasClass('multiselect')) {
                $('.multi-select-full .validation-error-label').remove();
                error.insertAfter(element.next('.btn-group'));
                }
            else if ( element.hasClass('colorpicker')) {
                    error.insertAfter(element.next('.sp-replacer'));
                    
                }    
            else if ( element.hasClass('file-input_control')) {
                error.appendTo( element.parent().parent().parent().parent());
            }      
            else if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline') || element.parents('label').hasClass('radio-inline-div')) {
                    if(element.parents('label').hasClass('radio-inline-div'))
                    {
                        error.insertAfter( element.parent().parent().parent().parent().parent().parent().parent().parent().parent() );
                    }
                    else{
                        error.appendTo( element.parent().parent().parent().parent() );}
                }
                 else {
                     
                    if(element.hasClass("use_type_radio"))
                    {
                        error.insertAfter( element.parent().parent().parent() );
                    }                    
                    else if(element.hasClass("lettergroup") )
                    {
                        error.insertAfter( element.parent().parent() );
                    }
                    else if(element.hasClass("fuel_typegroup"))
                    {
                        error.appendTo( element.parent().parent().parent());
                    }
                    else
                    {
                        if(element.hasClass("finance_type_radio"))
                        {error.insertAfter( element.parent().parent().siblings(":last"));}
                        else
                            error.insertBefore( element.parent().parent().parent().parent().parent()); 
                    }
                }
            }
            // Unstyled checkboxes, radios
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }
            else {
                if (element.parents('table').hasClass('frequency_table'))
                {  
                    element.parent().addClass('validate_tr');
                }
                else
                {
                    error.insertAfter(element);
                }
            }
        },
        validClass: "validation-valid-label",
        rules: {
            password: {
                minlength: 5
            },
            repeat_password: {
                equalTo: "#password"
            },
            email: {
                email: true
            },
            repeat_email: {
                equalTo: "#email"
            },
            minimum_characters: {
                minlength: 10
            },
            maximum_characters: {
                maxlength: 10
            },
            minimum_number: {
                min: 10
            },
            maximum_number: {
                max: 10
            },
            number_range: {
                range: [10, 20]
            },
            url: {
                url: true
            },
            date: {
                date: true
            },
            date_iso: {
                dateISO: true
            },
            numbers: {
                number: true
            },
            digits: {
                digits: true
            },
            creditcard: {
                creditcard: true
            },
            basic_checkbox: {
                minlength: 2
            },
            styled_checkbox: {
                minlength: 2
            },
            switchery_group: {
                minlength: 2
            },
            switch_group: {
                minlength: 2
            }
        },
        messages: {
            custom: {
                required: "This is a custom error message",
            },
            agree: "Please accept our policy"
        }
    });
}

function show_notification(type, message) {
    var n = noty({
                layout: 'topCenter',
                theme: 'defaultTheme', // or relax
                type: type, // success, error, warning, information, notification
                text: message,
                timeout: 3000,
                animation: {
                        open: {height: 'toggle'},
                        close: {height: 'toggle'},
                        easing: 'swing',
                        speed: 500 // opening & closing animation speed
                }
        });
}

function convertSerializedArrayToHash(a) { 
    var r = {};
    for (var i = 0;i<a.length;i++) { 
        var a_name = a[i].name;
        if((a[i].name).startsWith('certificate_id'))
            a_name = "'"+a[i].name+"'";
        
      r[a_name] = a[i].value;
    }
    return r;
}

function hashDiff(old_form, new_form) {
    var data = {};
    var field_data = {};
    var count = 0;
    for (field_name in new_form) {
        if (old_form[field_name] !== new_form[field_name]) 
        {
            field_data[count] = field_name;
            data['field_data'] = field_data;
            data["old_"+field_name] = old_form[field_name];
            data["new_"+field_name] = new_form[field_name];
            count++;
        }
    }
    for (field_name in old_form) {
        if (old_form[field_name] !== new_form[field_name]) 
        {
            field_data[count] = field_name;
            //if(!$.inArray(field_data[count],data['field_data'])){
            data['field_data'] = field_data;
            //}
            data["old_"+field_name] = old_form[field_name];
            data["new_"+field_name] = new_form[field_name];
            count++;
        }
    }
    return data;
}

function ajaxLoad(filename,content,table_id='') {
    $('#search').attr('disabled','disabled');
    content = typeof content !== 'undefined' ? content : '';
    $(".loading").show();
    $.ajax({
        type: "GET", 
        url: filename,  // no base url required filename is includes baseurl.
        data: content,
        contentType: false,
        success: function (data) {
            $("#list_load").html(data);
            // $(table_id).load(location.href + ' '+table_id);
        },
        error: function (xhr, status, error) {
            alert("Whoops, looks like something went wrong");
        },
        complete:function(result){
            $('#search').focus(); 
            var tmpStr = $('#search').val();
            $('#search').val('');
            $('#search').val(tmpStr);
            $('#search').focus();
            $('#search').removeAttr('disabled','disabled');
            $('#search').focus();

            if(result.responseText == '{"error":"Unauthenticated."}')
                {
                window.location.href = "login";         
            }
            listing_page_common_js();
            $(".loading").hide();           
        }
    });
}

function isEmpty(val) 
{

    // test results
    //---------------
    // []        true, empty array
    // {}        true, empty object
    // null      true
    // undefined true
    // ""        true, empty string
    // ''        true, empty string
    // 0         false, number
    // true      false, boolean
    // false     false, boolean
    // Date      false
    // function  false

    if (val === undefined){
        return true;
    }

    if (typeof (val) == 'function' || typeof (val) == 'number' || typeof (val) == 'boolean' || Object.prototype.toString.call(val) === '[object Date]'){
        return false;
    }

    // null or 0 length array
    if (val == null || val.length === 0){
        return true;
    }        

    // empty object
    if (typeof (val) == "object") {
        var r = true;
        for (var f in val){
            r = false;
        }
        return r;
    }
}

function valid_file_upload() 
{
    $('input[type=file]').on('change',function() { 
    var val = $(this).val();
    var names = [];
    for (var i = 0; i < $(this).get(0).files.length; ++i) {

        var file_name = $(this).get(0).files[i].name; 
        var file_ext = file_name.substring(file_name.lastIndexOf('.') + 1).toLowerCase();

        if (file_ext!='pdf' && file_ext!='doc' && file_ext!='docx' && file_ext!='xls' && file_ext!='xlsx' && file_ext!='ppt' && file_ext!='jpg' && file_ext!='jpeg' && file_ext!='png' && file_ext!='txt') 
        {
            names.push(file_name);
        }
    }
    // var fname = val.substring(val.lastIndexOf('\\') + 1).toLowerCase();
        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
            case 'pdf': case 'doc': case 'docx': case 'xls': case 'xlsx': case 'ppt': case 'jpg': case 'jpeg': case 'png': case 'txt' :
                break;
            default:
                $(this).val('');
                $(".special_check .fileinput-remove").click();
                // $(this).valid('');
                // $(this).fileinput('clear');
                show_notification('error','You can not upload '+ names +' file.');
                break;
        }
    });
}

function valid_image_upload() 
{
    $('input[type=file]').on('change',function() { 
        var val = $(this).val();
        var names = [];
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            var file_name = $(this).get(0).files[i].name; 
            var file_ext = file_name.substring(file_name.lastIndexOf('.') + 1).toLowerCase();
            if (file_ext!='jpg' && file_ext!='jpeg' && file_ext!='png') {
                names.push(file_name);
            }
        }
        if(!isEmpty(names))
        {
            $(this).val('');
            show_notification('error','You can not upload '+ names +' file.');
        }
    });
}

function delete_conf_common(record_id, model, db_table, display_title, table_id, extra_checks = '')
{
    $('.module_action').html('Delete');
    $('#module_title').html(" "+display_title);
    $('#delete-btn').attr('onclick','delete_common("'+record_id+'","'+model+'","'+db_table+'","'+display_title+'","'+table_id+'","'+extra_checks+'")');
    $('#delete_confirm').modal('show');
    return false;
}

function delete_common(record_id, model, db_table, display_title, table_id_or_url, extra_checks = '')
{
    $.ajax({
            type: "POST",
            url: ADMIN_URL+"delete_common",
            data:{
                record_id: record_id,
                model: model,
                db_table: db_table,
                display_title: display_title
            },
            success: function(data){
                $('#delete_confirm').modal('hide');
                if(data.status == 'success'){
                    show_notification(data.status,data.message);
                }else{
                    show_notification(data.status,data.message);
                }
            },
            complete:function(e){
                if(extra_checks == 'URL')
                {
                    ajaxLoad(table_id_or_url);
                }
                else
                {
                    $('#'+table_id_or_url).load(location.href + ' #'+table_id_or_url);
                }
            },
            error: function(e){
                console.log(e);
            }
        });
}

function active_inactive_common(record_id, model, db_table, display_title, table_id_or_url, extra_checks = '')
{
    $.ajax({
        type: "POST",
        url: ADMIN_URL+"active_inactive_common",
        data:{
            record_id: record_id,
            model: model,
            db_table: db_table,
            display_title: display_title
        },
        success: function(data){
            if(data.status == 'success'){
                show_notification(data.status,data.message);
            }else{
                show_notification(data.status,data.message);
            }
        },
        complete:function(e){
            if(extra_checks == 'URL')
            {
                ajaxLoad(table_id_or_url);
            }
            else
            {
                $('#'+table_id_or_url).load(location.href + ' #'+table_id_or_url);
            }
        },
        error: function(e){
            console.log(e);
        }
    });
}

function listing_page_common_js()
{
    // $("#search").on('keyup', function(){ 
    //     clearTimeout( $(this).data('timer'));
    //      var timer = setTimeout(function() {
    //         comapny_tiles_list_load();
    //      },700); 
    //     $(this).data('timer', timer); 
    // });

    $(".search_dropdown").select2({ width: '100%',}).on("select2:close", function (e) { });
    $(".simple_dropdown").select2({ width: '100%',minimumResultsForSearch: -1,height: '10px'}).on("select2:close", function (e) { });

    $('.pagination a').on('click', function (event) {
        event.preventDefault();
        ajaxLoad($(this).attr('href'));
    });

    var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
        switches.forEach(function(html) {
        var switchery = new Switchery(html, {color: '#4CAF50'});
    });
}