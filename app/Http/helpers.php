<?php
    use Illuminate\Support\Facades\Session;
    
    function getModuleData($module_slug)
    {
        $result_arr = false;

        if(!empty($module_slug))
        {
            switch (strtoupper($module_slug)) 
            {
                case 'DASHBOARD':
                    $model_class = 'Dashboard';
                    $folder_path = 'dashboard';
                    $sub_module = [];
                    break;
                case 'CONTRACT':
                    $model_class = 'Contract';
                    $folder_path = 'contract';
                    $sub_module = [];
                    break;
                case 'PROPERTIES':
                    $model_class = 'Property';
                    $folder_path = 'property';
                    $sub_module = ['PROPERTIES', 'PROPERTY_JOB', 'PROPERTY_APPLIANCE'];
                    break;
                case 'PROPERTY_JOB':
                case 'PROPERTY_APPLIANCE':
                    $model_class = 'Property';
                    $folder_path = 'property';
                    $sub_module = [];
                    break;
                case 'JOBS':
                    $model_class = 'Job';
                    $folder_path = 'job';
                    $sub_module = ['JOBS','JOB_STATUS','JOB_NOTEPAD'];
                    break;
                case 'JOB_STATUS':
                case 'JOB_NOTEPAD':
                    $model_class = 'Job';
                    $folder_path = 'job';
                    $sub_module = [];
                    break;
                case 'REPORTS':
                    $model_class = 'Reports';
                    $folder_path = 'reports';
                    $sub_module = [];
                    break;
                default:
                    $model_class = '';
                    $folder_path = '';
                    $sub_module = [];
                    break;
            }

            if(!empty($model_class) && !empty($folder_path)){
                $result_arr['class_name'] =  $model_class;
                $result_arr['folder_path'] =  $folder_path;
                $result_arr['sub_module'] =  $sub_module;
            }

            if(!empty(Session::get('user_modules'))){
                $user_modules = Session::get('user_modules');
                $result_arr['add'] = $user_modules[$module_slug]['add'] == 1 ? $user_modules[$module_slug]['add'] : false;
                $result_arr['edit'] = $user_modules[$module_slug]['edit'] == 1 ? $user_modules[$module_slug]['edit'] : false;
                $result_arr['delete'] = $user_modules[$module_slug]['delete'] == 1 ? $user_modules[$module_slug]['delete'] : false;
                $result_arr['view'] = $user_modules[$module_slug]['view'] == 1 ? $user_modules[$module_slug]['view'] : false;
            }

            return $result_arr;
        }
        return false;
    }

    //for ui format
    function dbDateFormat($date = '') 
    {
        if($date == '' || $date == null)
            $return_date = null;
        else{
            $date = new \DateTime(str_ireplace('/', '-', $date));
            $return_date = $date->format('Y-m-d');
        }
        return $return_date;
    }

    //for ui format
    function dbDatetimeFormat($datetime = '') 
    {
        if ($datetime == '' || $datetime == null)
            $return_date_time = null;
        else{
            $datetime = new \DateTime(str_ireplace('/', '-', $datetime));
            $return_date_time = $datetime->format('Y-m-d H:i:s');
        }
        return $return_date_time;
    }

    function isJSON($string)
    {
       return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    function dateToFormatString($date='',$replace_key='|') 
    {
        return str_replace("-", $replace_key, db_date_format($date));
    }

    function getPagefromUrl($url){
        $page_url_arr = explode('?', $url);
        $page_arr = explode('=', $page_url_arr[1]);
        return $page_arr[1];
    }

    function getPageStartCount($cur_page)
    {
        $start_from = $cur_page;
        if($cur_page-2!=0 && $cur_page-2>=1)
        {
            $start_from = $cur_page-2;
        }
        else if($cur_page-1!=0  && $cur_page-1>=1)
        {
            $start_from = $cur_page-1;
        }
        return $start_from;
    }

    /* View page prev next button - START */
    function get_prevnext_record($result_arr, $current_value, $prev_next)
    {
        $current_key = array_search($current_value, $result_arr);
        if ($prev_next == 'prev' && $current_key != 0)
        {
            $return_record = $result_arr[$current_key-1];
        }
        else if($prev_next == 'next' && ($current_key != sizeof($result_arr)-1))
        {
            $return_record = $result_arr[$current_key+1];
        }
        else
        {
            $return_record = 0;
        }
        return $return_record;
    }
    /* View page prev next button - END */

    //------to generate string alert for server action------
    function validation_msg($action_name,$module_name='', $field_name='',$max_len='',$email_exist='',$min_len='',$compare_f1='',$compare_f2='',$verify='',$ac_disabled=''){
        $public_path = public_path().'/validation_message.json';
        $file_content = file_get_contents($public_path);
        $json = json_decode($file_content, true);
        $msg_string = $json[$action_name];
        
        if ($field_name !='')
            $msg_string = $field_name." ".$msg_string;

        if ($module_name !='')
            $msg_string = $module_name." ".$msg_string;

        if ($max_len !='')
            $msg_string = $msg_string." and must be less than ".$max_len." characters.";

        if ($min_len !='')
            $msg_string = $msg_string." and must be greater than ".$min_len." characters.";

        if ($email_exist !='')
            $msg_string = $msg_string." ".$email_exist;

        if ($compare_f1 !='' && $compare_f2 !='')
            $msg_string = $compare_f1." and ".$compare_f2." ".$msg_string;

        if ($verify !='')
            $msg_string = $msg_string." ".$verify;

        if ($ac_disabled !='')
            $msg_string = $msg_string;

        return ucfirst($msg_string);
    }

    function checkArraySame($arr1=[],$arr2=[])
    {
        if(empty(array_diff($arr1,$arr2)) && empty(array_diff($arr2,$arr1))){
            return true;
        }else{
            return false;   
        }
    }

    function columnShowData($module_slug,$column_data)
    {
        $main_column_data = Session::get('user_search_criteria');
        $update_check = false;
        if(!empty($main_column_data[$module_slug]))
        {
            $main_col_arr = $main_column_data[$module_slug];
            $is_same = checkArraySame($main_col_arr,$column_data);
            if(!$is_same){
                $update_check = true;
            }
        }
        else
        {
            $update_check = true;
            
        }

        if($update_check)
        {
            $main_column_data[$module_slug] = $column_data;
            Session::put('user_search_criteria',$main_column_data);
            $api_req['columns_for_filter'] = $column_data;
            return $api_req;
        }   
        else
        {
            return [];
        }
    }

    function format_date_blade($date_value = '',$format='') {
        if ($date_value == '' || $date_value == null) {
            $return_date_time = '';
        }
        else {
            $date = new DateTime($date_value);
            if ($format == '')
            {$return_date_time = $date->format('d-m-Y');}
            else
            {$return_date_time = $date->format($format);}
        }
        return $return_date_time;
    }

    function format_datetime_blade($date_value = '') {
        if ($date_value == '' || $date_value == null) {
            $return_date_time = '';
        }
        else {
            $date = new \DateTime($date_value);
            $return_date_time = $date->format('d-m-Y H:i:s');
        }
        return $return_date_time;
    }
?>