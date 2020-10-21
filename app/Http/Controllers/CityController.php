<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\State;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $states = State::getState();
    	return view('admin.city.city',compact('states'));
    }

    public function list(Request $request)
    {
        if(app('request')->exists('reset') && $request->reset==true)
        {
            Session::forget('search_city');
            Session::forget('city_field');
            Session::forget('city_sort');
            Session::forget('city_show');
        }

        Session::put('search_city', $request->has('ok') ? $request->search : (Session::has('search_city') ? Session::get('search_city') : ''));
        Session::put('city_show', $request->has('show') ? $request->show : (Session::has('city_show') ? Session::get('city_show') : '10'));
        Session::put('city_field', $request->has('field') ? $request->field : (Session::has('city_field') ? Session::get('city_field') : 'id'));
        Session::put('city_sort', $request->has('sort') ? $request->sort : (Session::has('city_sort') ? Session::get('city_sort') : 'desc'));

        $search_box = Session::get('search_city');

        $query = City::select('cities.*');
        if($search_box != ''){       
            $query->where(function($q) use ($search_box){
                $q->where('cities.city', 'LIKE', '%'.$search_box.'%')
                ->orwhere('cities.created_at', 'LIKE', '%'.$search_box.'%')
                ->orwhere('cities.updated_at', 'LIKE', '%'.$search_box.'%');
            });
        }

        $cities = $query->orderBy(Session::get('city_field'), Session::get('city_sort'))
                        ->paginate(Session::get('city_show'));

        if($cities) {
            return view('admin.city.list',compact('cities'));
        }else{
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function edit(Request $request,$id)
    {
        $cities = City::getCity($id);
        if($cities) {
            return response()->json($cities);
        }
        else{
            return response()->json(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function store(Request $request)
    {
        if(!empty($request->id)){
            $validate['city']="required|unique:cities,city,$request->id,id,deleted_at,NULL|max:128";
        }else{
            $validate['city']="required|unique:cities|max:128";
        }

        $validate['state_id']="required";
        $validatedData = $request->validate($validate);

        $save_data['city']=$request->city;
        $save_data['state_id']=$request->state_id;
                        
        $result = City::saveCity($save_data,$request->id);
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
