<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Care;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CareController extends Controller
{
    public function index(Request $request)
    {
    	return view('admin.care.care');
    }

    public function list(Request $request)
    {
        if(app('request')->exists('reset') && $request->reset==true)
        {
            Session::forget('search_care');
            Session::forget('care_field');
            Session::forget('care_sort');
            Session::forget('care_show');
        }

        Session::put('search_care', $request->has('ok') ? $request->search : (Session::has('search_care') ? Session::get('search_care') : ''));
        Session::put('care_show', $request->has('show') ? $request->show : (Session::has('care_show') ? Session::get('care_show') : '10'));
        Session::put('care_field', $request->has('field') ? $request->field : (Session::has('care_field') ? Session::get('care_field') : 'id'));
        Session::put('care_sort', $request->has('sort') ? $request->sort : (Session::has('care_sort') ? Session::get('care_sort') : 'desc'));

        $search_box = Session::get('search_care');

        $query = Care::select('cares.*');
        if($search_box != ''){       
            $query->where(function($q) use ($search_box){
                $q->where('cares.care', 'LIKE', '%'.$search_box.'%')
                ->orwhere('cares.created_at', 'LIKE', '%'.$search_box.'%')
                ->orwhere('cares.updated_at', 'LIKE', '%'.$search_box.'%');
            });
        }

        $cares = $query->orderBy(Session::get('care_field'), Session::get('care_sort'))
                        ->paginate(Session::get('care_show'));

        if($cares) {
            return view('admin.care.list',compact('cares'));
        }else{
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function edit(Request $request,$id)
    {
        $cares = Care::getCare($id);
        if($cares) {
            return response()->json($cares);
        }
        else{
            return response()->json(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function store(Request $request)
    {
        if(!empty($request->id)){
            $validate['care']="required|unique:cares,care,$request->id,id,deleted_at,NULL|max:128";
        }else{
            $validate['care']="required|unique:cares|max:128";
        }
        
        $validatedData = $request->validate($validate);

        $save_data['care']=$request->care;
                        
        $result = Care::saveCare($save_data,$request->id);
        if($result)
        {
            return response()->json(['status'=>'success','message'=>$result['message']]);
        }
        else
        {
            return response()->json(['status'=>'error','message'=>'Something went wrong.']);
        }
    }
}
