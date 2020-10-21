<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Amenity;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AmenityController extends Controller
{
    public function index(Request $request)
    {
    	return view('admin.amenity.amenity');
    }

    public function list(Request $request)
    {
        if(app('request')->exists('reset') && $request->reset==true)
        {
            Session::forget('search_amenity');
            Session::forget('amenity_field');
            Session::forget('amenity_sort');
            Session::forget('amenity_show');
        }

        Session::put('search_amenity', $request->has('ok') ? $request->search : (Session::has('search_amenity') ? Session::get('search_amenity') : ''));
        Session::put('amenity_show', $request->has('show') ? $request->show : (Session::has('amenity_show') ? Session::get('amenity_show') : '10'));
        Session::put('amenity_field', $request->has('field') ? $request->field : (Session::has('amenity_field') ? Session::get('amenity_field') : 'id'));
        Session::put('amenity_sort', $request->has('sort') ? $request->sort : (Session::has('amenity_sort') ? Session::get('amenity_sort') : 'desc'));

        $search_box = Session::get('search_amenity');

        $query = Amenity::select('amenties.*');
        if($search_box != ''){       
            $query->where(function($q) use ($search_box){
                $q->where('amenties.amenity', 'LIKE', '%'.$search_box.'%')
                ->orwhere('amenties.created_at', 'LIKE', '%'.$search_box.'%')
                ->orwhere('amenties.updated_at', 'LIKE', '%'.$search_box.'%');
            });
        }

        $amenties = $query->orderBy(Session::get('amenity_field'), Session::get('amenity_sort'))
                        ->paginate(Session::get('amenity_show'));

        if($amenties) {
            return view('admin.amenity.list',compact('amenties'));
        }else{
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function edit(Request $request,$id)
    {
        $amenties = Amenity::getAmenity($id);
        if($amenties) {
            return response()->json($amenties);
        }
        else{
            return response()->json(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function store(Request $request)
    {
        if(!empty($request->id)){
            $validate['amenity']="required|unique:amenties,amenity,$request->id,id,deleted_at,NULL|max:128";
        }else{
            $validate['amenity']="required|unique:amenties|max:128";
        }
        
        $validatedData = $request->validate($validate);

        $save_data['amenity']=$request->amenity;
                        
        $result = Amenity::saveAmenity($save_data,$request->id);
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
