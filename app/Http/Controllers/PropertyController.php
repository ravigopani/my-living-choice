<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Common;
use App\Property;
use App\User;
use App\State;
use App\City;
use App\Care;
use App\Amenity;
use App\Package;
use App\PropertyCare;
use App\PropertyGallery;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Hash;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
    	return view('admin.property.base');
    }

    public function list(Request $request)
    {
        if(app('request')->exists('reset') && $request->reset==true)
        {
            Session::forget('search_property');
            Session::forget('property_field');
            Session::forget('property_sort');
            Session::forget('property_show');
        }

        Session::put('search_property', $request->has('ok') ? $request->search : (Session::has('search_property') ? Session::get('search_property') : ''));
        Session::put('property_show', $request->has('show') ? $request->show : (Session::has('property_show') ? Session::get('property_show') : '10'));
        Session::put('property_field', $request->has('field') ? $request->field : (Session::has('property_field') ? Session::get('property_field') : 'id'));
        Session::put('property_sort', $request->has('sort') ? $request->sort : (Session::has('property_sort') ? Session::get('property_sort') : 'desc'));

        $search_box = Session::get('search_property');

        $query = Property::select('properties.*');
        if($search_box != ''){       
            $query->where(function($q) use ($search_box){
                $q->where('properties.name', 'LIKE', '%'.$search_box.'%')
                ->orwhere('properties.address', 'LIKE', '%'.$search_box.'%')
                ->orwhere('properties.phone_number', 'LIKE', '%'.$search_box.'%')
                ->orwhere('properties.contact_email', 'LIKE', '%'.$search_box.'%')
                ->orwhere('properties.website', 'LIKE', '%'.$search_box.'%');
            });
        }

        $properties = $query->orderBy(Session::get('property_field'), Session::get('property_sort'))
                ->paginate(Session::get('property_show'));

        if($properties) {
            return view('admin.property.list',compact('properties'));
        }else{
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function create(Request $request)
    {
        $owners = User::where('user_type','Owner')->get();
        $states = State::get();
        $cares = Care::get();
        $amenities = Amenity::get();
        $packages = Package::get();
        return view('admin.property.add_edit', compact('owners','states','cares','amenities','packages'));
    }

    public function edit(Request $request,$id)
    {
        $property = Property::getProperty($id);
        if(!$property) {
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }

        $owners = User::where('user_type','Owner')->get();
        $states = State::get();
        if($property->state_id != ''){
            $cities = City::where('state_id',$property->state_id)->get();    
        }
        
        $cares = Care::get();
        $amenities = Amenity::get();
        $packages = Package::get();
        $property_gallery = PropertyGallery::where('property_id',$id)->get();
        $property_cares = PropertyCare::where('property_id',$id)->get()->toArray();

        return view('admin.property.add_edit',compact('property','owners','states','cares','amenities','packages','property_gallery','property_cares','cities'));
    }

    public function store(Request $request)
    {
        $validate['name'] = 'required|max:128';
        $validate['website'] = 'max:128';
        $validate['owner_id'] = 'numeric';
        $validate['address'] = 'required|max:256';
        $validate['state_id'] = 'max:3' ;
        $validate['city_id'] = 'max:3';
        $validate['zip'] = 'max:10';
        $validate['latitude'] = 'max:15';
        $validate['longitude'] = 'max:15';
        $validate['phone_number'] = 'max:15';
        $validate['call_tracking_phone_number'] = 'max:15';
        $validate['contact_name'] = 'max:128';
        $validate['contact_email'] = 'max:128';
        $validate['facebook_link'] = 'max:128';
        $validate['linkedin_link'] = 'max:128';
        $validate['twitter_link'] = 'max:128';
        $validate['instagram_link'] = 'max:128';
        $validate['short_description'] = 'max:512';
        $validate['long_description'] = 'max:65535';

        if(!empty($validate['year_opened'])){
            $validate['year_opened'] = 'numeric|digits_between:0,4';            
        }
        if(!empty($validate['total_units'])){
            $validate['total_units'] = 'numeric|digits_between:0,10';
        }
        if(!empty($validate['package_id'])){
            $validate['package_id'] = 'numeric|digits_between:0,3';
        }

        $validatedData=$request->validate($validate);

        $save_data['name']=$request->name;
        $save_data['website']=$request->website;
        $save_data['owner_id']=$request->owner_id;
        $save_data['address']=$request->address;
        $save_data['state_id']=$request->state_id;
        $save_data['city_id']=$request->city_id;
        $save_data['zip']=$request->zip;
        $save_data['latitude']=$request->latitude;
        $save_data['longitude']=$request->longitude;
        $save_data['phone_number']=$request->phone_number;
        $save_data['call_tracking_phone_number']=$request->call_tracking_phone_number;
        $save_data['contact_name']=$request->contact_name;
        $save_data['contact_email']=$request->contact_email;
        $save_data['facebook_link']=$request->facebook_link;
        $save_data['linkedin_link']=$request->linkedin_link;
        $save_data['twitter_link']=$request->twitter_link;
        $save_data['instagram_link']=$request->instagram_link;
        $save_data['short_description']=$request->short_description;
        $save_data['long_description']=$request->long_description;
        $save_data['year_opened']=$request->year_opened;
        $save_data['starting_price']=$request->starting_price;
        $save_data['total_units']=$request->total_units;
        $save_data['package_id']=$request->package_id;
        $save_data['amenities']=!empty($request->amenities) ? implode(',', $request->amenities) : '';
        $save_data['show_in_list']=strtolower($request->show_in_list)=='yes' ? 'Yes' : 'No';


        if (!file_exists(storage_path('/propertyImage'))) {
            mkdir(storage_path('/propertyImage'), 0777, true);
        }

        $header_image_name = '';
        if($request->file('header_image'))
        {
            $header_image = $request->file('header_image');
            $header_image_name = time().'-'.$header_image->getClientOriginalName();
            $destinationPath = storage_path('/propertyImage');
            $header_image->move($destinationPath, $header_image_name);
        }
        if($header_image_name  != ''){
            $save_data['header_image'] = $header_image_name;
        }

        $logo_image_name = '';
        if($request->file('logo_image'))
        {
            $logo_image = $request->file('logo_image');
            $logo_image_name = time().'-'.$logo_image->getClientOriginalName();
            $destinationPath = storage_path('/propertyImage');
            $logo_image->move($destinationPath, $logo_image_name);
        }
        if($logo_image_name  != ''){
            $save_data['logo_image'] = $logo_image_name;
        }

        $result = Property::saveProperty($save_data);

        if($result)
        {
            if(!empty($request->cares))
            {
                foreach ($request->cares as $value) 
                {
                    PropertyCare::savePropertyCare(['property_id'=>$result['id'], 'care_id'=>$value]);
                }
            }

            return redirect(\Config::get('constants.ADMIN_URL').'property')->with(['status'=>'success','message'=>$result['message']]);
        }
        else
        {
            return Redirect::back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function update(Request $request,$id)
    {
        $validate['name'] = 'required|max:128';
        $validate['website'] = 'max:128';
        $validate['owner_id'] = 'numeric';
        $validate['address'] = 'required|max:256';
        $validate['state_id'] = 'max:3' ;
        $validate['city_id'] = 'max:3';
        $validate['zip'] = 'max:10';
        $validate['latitude'] = 'max:15';
        $validate['longitude'] = 'max:15';
        $validate['phone_number'] = 'max:15';
        $validate['call_tracking_phone_number'] = 'max:15';
        $validate['contact_name'] = 'max:128';
        $validate['contact_email'] = 'max:128';
        $validate['facebook_link'] = 'max:128';
        $validate['linkedin_link'] = 'max:128';
        $validate['twitter_link'] = 'max:128';
        $validate['instagram_link'] = 'max:128';
        $validate['short_description'] = 'max:512';
        $validate['long_description'] = 'max:65535';
        if(!empty($validate['year_opened'])){
            $validate['year_opened'] = 'numeric|digits_between:0,4';            
        }
        if(!empty($validate['total_units'])){
            $validate['total_units'] = 'numeric|digits_between:0,10';
        }
        if(!empty($validate['package_id'])){
            $validate['package_id'] = 'numeric|digits_between:0,3';
        }

        $validatedData=$request->validate($validate);

        $save_data['name']=$request->name;
        $save_data['website']=$request->website;
        $save_data['owner_id']=$request->owner_id;
        $save_data['address']=$request->address;
        $save_data['state_id']=$request->state_id;
        $save_data['city_id']=$request->city_id;
        $save_data['zip']=$request->zip;
        $save_data['latitude']=$request->latitude;
        $save_data['longitude']=$request->longitude;
        $save_data['phone_number']=$request->phone_number;
        $save_data['call_tracking_phone_number']=$request->call_tracking_phone_number;
        $save_data['contact_name']=$request->contact_name;
        $save_data['contact_email']=$request->contact_email;
        $save_data['facebook_link']=$request->facebook_link;
        $save_data['linkedin_link']=$request->linkedin_link;
        $save_data['twitter_link']=$request->twitter_link;
        $save_data['instagram_link']=$request->instagram_link;
        $save_data['short_description']=$request->short_description;
        $save_data['long_description']=$request->long_description;
        $save_data['year_opened']=$request->year_opened;
        $save_data['starting_price']=$request->starting_price;
        $save_data['total_units']=$request->total_units;
        $save_data['package_id']=$request->package_id;
        $save_data['amenities']=!empty($request->amenities) ? implode(',', $request->amenities) : '';
        $save_data['show_in_list']=strtolower($request->show_in_list)=='yes' ? 'Yes' : 'No';

        $property_cares = PropertyCare::where('property_id',$id)->get()->toArray();

        $old_property_cares = [];
        if(!empty($property_cares)){
            foreach ($property_cares as $key => $value) {
                $old_property_cares[] = $value['care_id'];
            }
        }

        $add_record = $delete_record = [];
        $delete_record = array_diff($old_property_cares,$request->cares);
        $add_record = array_diff($request->cares,$old_property_cares);

        if(!empty($add_record))
        {
            foreach ($add_record as $value) 
            {
                $result = PropertyCare::savePropertyCareWithExistCheck($id,$value);
            }
        }

        if(!empty($delete_record))
        {
            foreach ($delete_record as $value) 
            {
                $result = PropertyCare::deletePropertyCare($id,$value);
            }
        }

        if (!file_exists(storage_path('/propertyImage'))) {
            mkdir(storage_path('/propertyImage'), 0777, true);
        }

        $header_image_name = '';
        if($request->file('header_image'))
        {
            $header_image = $request->file('header_image');
            $header_image_name = time().'-'.$header_image->getClientOriginalName();
            $destinationPath = storage_path('/propertyImage');
            $header_image->move($destinationPath, $header_image_name);
        }
        if($header_image_name  != ''){
            $save_data['header_image'] = $header_image_name;
        }

        $logo_image_name = '';
        if($request->file('logo_image'))
        {
            $logo_image = $request->file('logo_image');
            $logo_image_name = time().'-'.$logo_image->getClientOriginalName();
            $destinationPath = storage_path('/propertyImage');
            $logo_image->move($destinationPath, $logo_image_name);
        }
        if($logo_image_name  != ''){
            $save_data['logo_image'] = $logo_image_name;
        }

        $result = Property::saveProperty($save_data,$id);
        if($result)
        {
            return redirect(\Config::get('constants.ADMIN_URL').'property/'.$result['id'].'/edit')->with(['status'=>'success','message'=>$result['message']]);
        }
        else
        {
            return Redirect::back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function add_photo(Request $request)
    {
        $validate['property_id'] = 'required|numeric';
        // $validate['file_upload'] = 'mimes:jpeg,jpg,png,gif|reqsuired|max:5000';
        $validatedData = $request->validate($validate);

        $temp_paths = [];
        if(!empty($request->file_upload))
        {
            foreach ($request->file_upload as $file) 
            {
                $filename = time().'_'.$file->getClientOriginalName();
                if (!file_exists(storage_path('/propertyGallery/'.$request->property_id))) {
                    mkdir(storage_path('/propertyGallery/'.$request->property_id), 0777, true);
                }
                $destinationPath = storage_path('/propertyGallery/'.$request->property_id);
                $file->move($destinationPath, $filename);
                $temp_paths['file_paths'][]=$filename;
            }
        }

        if(!empty($temp_paths['file_paths']))
        {
            foreach ($temp_paths['file_paths'] as $key => $value) 
            {
                $save_data = [];
                $save_data['property_id']=$request->property_id;
                $save_data['file_path'] = $value;
                $result = PropertyGallery::savePropertyGallery($save_data,$request->id);
            }
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
}
