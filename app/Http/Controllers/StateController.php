<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class StateController extends Controller
{
    public function index(Request $request)
    {
    	return view('admin.state.state');
    }

    public function list(Request $request)
    {
        if(app('request')->exists('reset') && $request->reset==true)
        {
            Session::forget('search_state');
            Session::forget('state_field');
            Session::forget('state_sort');
            Session::forget('state_show');
        }

        Session::put('search_state', $request->has('ok') ? $request->search : (Session::has('search_state') ? Session::get('search_state') : ''));
        Session::put('state_show', $request->has('show') ? $request->show : (Session::has('state_show') ? Session::get('state_show') : '10'));
        Session::put('state_field', $request->has('field') ? $request->field : (Session::has('state_field') ? Session::get('state_field') : 'id'));
        Session::put('state_sort', $request->has('sort') ? $request->sort : (Session::has('state_sort') ? Session::get('state_sort') : 'desc'));

        $search_box = Session::get('search_state');

        $query = State::select('states.*');
        if($search_box != ''){       
            $query->where(function($q) use ($search_box){
                $q->where('states.state', 'LIKE', '%'.$search_box.'%')
                ->orwhere('states.created_at', 'LIKE', '%'.$search_box.'%')
                ->orwhere('states.updated_at', 'LIKE', '%'.$search_box.'%');
            });
        }

        $states = $query->orderBy(Session::get('state_field'), Session::get('state_sort'))
                        ->paginate(Session::get('state_show'));

        if($states) {
            return view('admin.state.list',compact('states'));
        }else{
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function edit(Request $request,$id)
    {
        $states = State::getState($id);
        if($states) {
            return response()->json($states);
        }
        else{
            return response()->json(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function store(Request $request)
    {
        if(!empty($request->id)){
            $validate['state']="required|unique:states,state,$request->id,id,deleted_at,NULL|max:128";
        }else{
            $validate['state']="required|unique:states|max:128";
        }
        
        $validatedData = $request->validate($validate);

        $save_data['state']=$request->state;
                        
        $result = State::saveState($save_data,$request->id);
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
