<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Image;

class CommonController extends Controller
{
    public function refresh_captcha_image(Request $request)
    {
    	return view('refresh_captcha_image');
    }

    public function delete_common(Request $request)
    {
    	if($request->record_id != '' && $request->model != '')
    	{
	    	$model_name = '\\App\\'.$request->model;
	        $model_obj = new $model_name;
	        $record = $model_obj->find($request->record_id);
	        if($record)
	        {
	        	$record->delete();
	        	return response()->json(['status'=>'success','message'=>$request->display_title.' deleted successfully.']);
	        }
	        else
	        {
	        	return response()->json(['status'=>'error','message'=>$request->display_title.' not found.']);
	        }
    	}
    	else
    	{
    		return response()->json(['status'=>'error','message'=>'Something went wrong.']);
    	}
    }

    public function active_inactive_common(Request $request)
    {
        if($request->record_id != '' && $request->model != '')
        {
            $model_name = '\\App\\'.$request->model;
            $model_obj = new $model_name;
            $record = $model_obj->find($request->record_id);
            $temp_label = '';

            if($record->status == 'A')
            {
                $record->status = 'I';
                $temp_label = ' In Activated ';
            }
            else
            {
                $record->status = 'A';
                $temp_label = ' Activated ';
            }

            if($record->save())
            {
                return response()->json(['status'=>'success','message'=>$request->display_title.$temp_label.' successfully.']);
            }
            else
            {
                return response()->json(['status'=>'error','message'=>$request->display_title.$temp_label.' not found.']);
            }
        }
        else
        {
            return response()->json(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function get_city_by_state(Request $request)
    {
        if(!empty($request->state))
        {
            $cities = DB::table('cities')->where('state_id',$request->state)->get();
            if($cities)
            {
                $str = '<option value="">Select</option>';
                foreach ($cities as $key => $value) 
                {
                    $str .= '<option value="'.$value->id.'">'.$value->city.'</option>';
                }
                return $str;
            }
            else
            {
                return response()->json(['status'=>'error','message'=>'City not found.']);
            }
        }
        else
        {
            return response()->json(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function get_image($file_path,$file_name,$extra='') 
    {
        if($file_path == 'propertyGallery')
        {
            $file = storage_path().'/'.$file_path.'/'.$extra.'/'.$file_name;
        }
        else
        {
            $file = storage_path().'/'.$file_path.'/'.$file_name;
        }

        
        return Image::make($file)->response();
    }

    public function download_doc_common(Request $request)
    {
        if(!empty($request->id) && !empty($request->module) && !empty($request->path))
        {
            $class_name = "\\App\\".$request->module;
            $obj = new $class_name;
            $data = $obj::where('id',$request->id)->first();
            $file_path = storage_path().'\\'.$request->path.'\\'.$data->file_path;

            if(file_exists($file_path)) 
            {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file_path));
                flush(); // Flush system output buffer
                readfile($file_path);
                exit;
            }
            else
            {
                return back()->with(['status'=>'error','message'=>'File not found.']);
            }
        }

    }
}
