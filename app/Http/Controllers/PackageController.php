<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    public function index(Request $request)
    {
    	return view('admin.package.package');
    }

    public function list(Request $request)
    {
        if(app('request')->exists('reset') && $request->reset==true)
        {
            Session::forget('search_package');
            Session::forget('package_field');
            Session::forget('package_sort');
            Session::forget('package_show');
        }

        Session::put('search_package', $request->has('ok') ? $request->search : (Session::has('search_package') ? Session::get('search_package') : ''));
        Session::put('package_show', $request->has('show') ? $request->show : (Session::has('package_show') ? Session::get('package_show') : '10'));
        Session::put('package_field', $request->has('field') ? $request->field : (Session::has('package_field') ? Session::get('package_field') : 'id'));
        Session::put('package_sort', $request->has('sort') ? $request->sort : (Session::has('package_sort') ? Session::get('package_sort') : 'desc'));

        $search_box = Session::get('search_package');

        $query = Package::select('packages.*');
        if($search_box != ''){       
            $query->where(function($q) use ($search_box){
                $q->where('packages.package', 'LIKE', '%'.$search_box.'%')
                ->orwhere('packages.created_at', 'LIKE', '%'.$search_box.'%')
                ->orwhere('packages.updated_at', 'LIKE', '%'.$search_box.'%');
            });
        }

        $packages = $query->orderBy(Session::get('package_field'), Session::get('package_sort'))
                        ->paginate(Session::get('package_show'));

        if($packages) {
            return view('admin.package.list',compact('packages'));
        }else{
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function edit(Request $request,$id)
    {
        $packages = Package::getPackage($id);
        if($packages) {
            return response()->json($packages);
        }
        else{
            return response()->json(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function store(Request $request)
    {
        if(!empty($request->id)){
            $validate['package']="required|unique:packages,package,$request->id,id,deleted_at,NULL|max:128";
        }else{
            $validate['package']="required|unique:packages|max:128";
        }
        
        $validatedData = $request->validate($validate);

        $save_data['package']=$request->package;
                        
        $result = Package::savePackage($save_data,$request->id);
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
