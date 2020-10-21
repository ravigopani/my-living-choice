<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Common;
use App\User;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
    	return view('admin.user.base');
    }

    public function list(Request $request)
    {
        if(app('request')->exists('reset') && $request->reset==true)
        {
            Session::forget('search_user');
            Session::forget('user_field');
            Session::forget('user_sort');
            Session::forget('user_show');
        }

        Session::put('search_user', $request->has('ok') ? $request->search : (Session::has('search_user') ? Session::get('search_user') : ''));
        Session::put('user_show', $request->has('show') ? $request->show : (Session::has('user_show') ? Session::get('user_show') : '10'));
        Session::put('user_field', $request->has('field') ? $request->field : (Session::has('user_field') ? Session::get('user_field') : 'id'));
        Session::put('user_sort', $request->has('sort') ? $request->sort : (Session::has('user_sort') ? Session::get('user_sort') : 'desc'));

        $search_box = Session::get('search_user');
        $show = Session::get('user_show');

        $query = User::select('users.*');
        if($search_box != ''){       
            $query->where(function($q) use ($search_box){
                $q->where('users.name', 'LIKE', '%'.$search_box.'%')
                ->orwhere('users.email', 'LIKE', '%'.$search_box.'%');
            });
        }

        $users = $query->orderBy(Session::get('user_field'), Session::get('user_sort'))->paginate($show);

        if($users) {
            return view('admin.user.list',compact('users'));
        }else{
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function create(Request $request)
    {
        return view('admin.user.add_edit');
    }

    public function edit(Request $request,$id)
    {
        $user = User::getUser($id);
        if(!$user) {
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
        return view('admin.user.add_edit',compact('user'));
    }

    public function store(Request $request)
    {
        $validate['name']='required|max:191';
        $validate['email']='required|unique:users|max:191';
        $validate['password']='required';
        $validate['user_type']='required';
        $validatedData=$request->validate($validate);

        $save_data['name']=$request->name;
        $save_data['email']=$request->email;
        $save_data['password']=Hash::make($request->password);
        $save_data['user_type']=$request->user_type;

        if (!file_exists(storage_path('/userProfilePicture'))) {
            mkdir(storage_path('/userProfilePicture'), 0777, true);
        }

        $profile_image_name = '';
        if($request->file('profile_image'))
        {
            $profile_image = $request->file('profile_image');
            $profile_image_name = time().'-'.$profile_image->getClientOriginalName();
            $destinationPath = storage_path('/userProfilePicture');
            $profile_image->move($destinationPath, $profile_image_name);
        }

        if($profile_image_name  != ''){
            $save_data['profile_image'] = $profile_image_name;
        }

        $result = User::saveUser($save_data);
        if($result)
        {
            return redirect(\Config::get('constants.ADMIN_URL').'user')->with(['status'=>'success','message'=>$result['message']]);
        }
        else
        {
            return Redirect::back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function update(Request $request,$id)
    {
        $validate['name']='required|max:191';
        $validate['email']="required|unique:users,email,{$id}|max:191";
        $validate['user_type']='required';
        $validatedData=$request->validate($validate);

        $save_data['name']=$request->name;
        $save_data['email']=$request->email;
        $save_data['user_type']=$request->user_type;

        if (!file_exists(storage_path('/userProfilePicture'))) {
            mkdir(storage_path('/userProfilePicture'), 0777, true);
        }

        $profile_image_name = '';
        if($request->file('profile_image'))
        {
            $profile_image = $request->file('profile_image');
            $profile_image_name = time().'-'.$profile_image->getClientOriginalName();
            $destinationPath = storage_path('/userProfilePicture');
            $profile_image->move($destinationPath, $profile_image_name);
        }

        if($profile_image_name  != ''){
            $save_data['profile_image'] = $profile_image_name;
        }

        $result = User::saveUser($save_data,$id);
        if($result)
        {
            return redirect(\Config::get('constants.ADMIN_URL').'user/'.$result['id'].'/edit')->with(['status'=>'success','message'=>$result['message']]);
        }
        else
        {
            return Redirect::back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function profile_edit(Request $request)
    {
        $user = User::select('users.*')
                    ->where('id',Auth::user()->id)
                    ->first();
     
        if(!$user) {
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }

        return view('admin.user.profile_edit',compact('user'));
    }

    public function profile_update(Request $request)
    {
        // echo "<pre>";
        // print_r($request->toArray());
        // exit();

        $id = Auth::user()->id;
        $validate['name']='required|max:191';
        $validate['email']="required|unique:users,email,{$id}|max:191";

        if(!empty($request->password) || !empty($request->password_confirmation))
        {
            if(!($request->password === $request->password_confirmation))
            {
                return Redirect::back()->with(['status'=>'error','message'=>'Password and Confirm Password does not match.']);   
            }
        }
        
        $validatedData=$request->validate($validate);

        $save_data['name']=$request->name;
        $save_data['email']=$request->email;

        if(!empty($request->password) && !empty($request->password_confirmation))
        {
            $save_data['password']=Hash::make($request->password);
        }
        
        if (!file_exists(storage_path('/userProfilePicture'))) {
            mkdir(storage_path('/userProfilePicture'), 0777, true);
        }

        $profile_image_name = '';
        if($request->file('profile_image'))
        {
            $profile_image = $request->file('profile_image');
            $profile_image_name = time().'-'.$profile_image->getClientOriginalName();
            $destinationPath = storage_path('/userProfilePicture');
            $profile_image->move($destinationPath, $profile_image_name);
        }

        if($profile_image_name  != ''){
            $save_data['profile_image'] = $profile_image_name;
        }

        $result = User::saveUser($save_data,$id);
        if($result)
        {
            return redirect(\Config::get('constants.ADMIN_URL').'profile_edit')->with(['status'=>'success','message'=>$result['message']]);
        }
        else
        {
            return Redirect::back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }

        return view('admin.user.profile_edit',compact('user'));
    }
}
