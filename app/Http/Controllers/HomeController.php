<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\Care;
use App\City;
use App\Property;
use App\PropertyCare;
use App\ContactUs;
use App\ListCommunity;
use App\PropertyGallery;
use App\Amenity;
use App\Tag;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $cares = Care::get()->toArray();
        $cities = City::select('cities.*','states.state')
                        ->join('states','cities.state_id','states.id')
                        ->get()->toArray();
        $blogs = Blog::where('status','A')->take(4)->latest()->get()->toArray();
        return view('front.index', compact('cares','cities','blogs'));
    }

    public function bestSeniorLiving()
    {
        $cares = Care::get()->toArray();
        return view('front.best_sinior_living', compact('cares'));
    }

    public function getPropertyByCare(Request $request)
    {
        $cities = City::select('cities.*','states.state')
                        ->join('states','cities.state_id','states.id')
                        ->get()->toArray();

        if(!empty($request->care)){
            $cares = Care::where('id',$request->care)->get()->toArray();
        }
        else{
            $cares = Care::get()->toArray();   
        }

        $properties = Property::select('properties.id','properties.name','properties.city_id','property_cares.care_id','cares.care')
                            ->leftJoin('property_cares','properties.id','property_cares.property_id')
                            ->join('cares','property_cares.care_id','cares.id')
                            ->whereNull('property_cares.deleted_at')
                            ->get()->toArray();

        return view('front.best_sinior_living_data', compact('cities','cares','properties'));   
    }

    public function search(Request $request)
    {
        $properties = Property::select('properties.id','properties.name','properties.latitude','properties.longitude')->get()->toArray();

        $lat_lng_array = [];
        if(!empty($properties)){
            foreach ($properties as $key => $value) {
                $lat_lng_array[] = ['lat'=>$value['latitude'],'lng'=>$value['longitude']];
            }
        }
        // echo "<pre>";
        // print_r($lat_lng_array);
        // exit();
        return view('maptest1',compact('properties','lat_lng_array'));
    }

    public function propertiesList(Request $request)
    {
        $care = '';
        if(!empty($request->care)){
            $care = Care::where('id',$request->care)->first();
        }

        $city = '';
        if(!empty($request->city)){
            $city = City::where('id',$request->city)->first();
        }

        return view('front.properties_list', compact('care','city'));
    }

    public function propertiesListData(Request $request)
    {
        $tmp_cares = Care::withTrashed()->get()->toArray();
        $cares = [];
        if(!empty($tmp_cares)){
            foreach ($tmp_cares as $value) {
              $cares[$value['id']] = $value['care'];
            }
        }

        $propertiesObj = Property::select('properties.*','packages.package')
                        ->join('packages','properties.package_id','packages.id');

        if(!empty($request->care)){
            $propertiesObj->whereHas('cares', function ($propertiesObj) use($request) {
                $propertiesObj->where('care_id', $request->care);
            });
        }

        if(!empty($request->city)){
            // $propertiesObj->where('city_id', $request->city);
        }

        $properties = $propertiesObj->with(['cares','gallery'])->orderBy('created_at','desc')->paginate(10);

        if($properties){
            $properties = $properties->toArray();
        }else{
            $properties = [];
        }

        // $property_cares = PropertyCare::where('property_id',2)->with(['care_detail'])->get()->toArray();
        // $property_gallery = PropertyGallery::where('property_id')->get()->toArray();
        // echo "<pre>";
        // print_r($properties);
        // exit();

        return view('front.properties_list_data', compact('properties','cares'));
    }

    public function propertiesSingle(Request $req, $id)
    {
        $propertiesObj = Property::select('properties.*','packages.package','cities.city','states.state')
                        ->join('packages','properties.package_id','packages.id')
                        ->join('cities','properties.city_id','cities.id')
                        ->join('states','properties.state_id','states.id');

        $property = $propertiesObj->with(['cares','gallery'])->first();

        $amenities = Amenity::get()->toArray();
        $cares = Care::get()->toArray();

        if($property){
            $property = $property->toArray();            
        }else{
            $property = [];
        }

        // echo "<pre>";
        // print_r($amenities);
        // exit();

        return view('front.properties_single', compact('property','amenities','cares'));
    }

    public function listCommunity()
    {
        return view('front.list-community');
    }

    public function postlistCommunity(Request $request)
    {
        $validate['name']="required|max:128";
        $validate['phone']="required|max:13";
        $validate['email']="required|max:128";
        $validate['website']="required|max:128";
        
        $validatedData = $request->validate($validate);

        $save_data['name']=$request->name;
        $save_data['phone']=$request->phone;
        $save_data['email']=$request->email;
        $save_data['website']=$request->website;
        $save_data['paid_advertising']=$request->paid_advertising == 'Yes' ? 'Yes' : 'No' ;
                        
        $result = ListCommunity::saveListCommunity($save_data);
        if($result){
            return redirect()->back()->with(['status'=>'success','message'=>$result['message']]);
        }
        else{
            return redirect()->back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function about()
    {
        $blogs = Blog::where('status','A')->take(4)->latest()->get()->toArray();
        return view('front.about', compact('blogs'));
    }

    public function contactUs()
    {
        return view('front.contact-us');
    }

    public function postContactUs(Request $request)
    {
        $validate['first_name']="required|max:128";
        $validate['last_name']="required|max:128";
        $validate['email']="required|max:128";
        $validate['phone_number']="required|max:15";
        $validate['message']="required|max:512";
        
        $validatedData = $request->validate($validate);

        $save_data['first_name']=$request->first_name;
        $save_data['last_name']=$request->last_name;
        $save_data['email']=$request->email;
        $save_data['phone_number']=$request->phone_number;
        $save_data['message']=$request->message;
                        
        $result = ContactUs::saveContactUs($save_data);
        if($result){
            return redirect()->back()->with(['status'=>'success','message'=>$result['message']]);
        }
        else{
            return redirect()->back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function blog(Request $req)
    {
        $top_articles = Blog::where('status','A')->take(4)->latest()->get()->toArray();
        $tags = Tag::get()->toArray();
        $tag = !empty($req->tag) ? $req->tag : '';
        return view('front.blog', compact('top_articles','tags','tag'));
    }

    public function blogListData(Request $request)
    {
        $blog_obj = Blog::select('blogs.*')->where('status','A');

        $search = !empty($request->search) ? $request->search : '';
        // $request->session()->put('search_blog', $search);

        if(!empty($search)){
            $blog_obj->where(function($blog_obj) use ($search){
                $blog_obj->where('blogs.title', 'LIKE', '%'.$search.'%');
                $blog_obj->orwhere('blogs.short_description', 'LIKE', '%'.$search.'%');
                $blog_obj->orwhere('blogs.long_description', 'LIKE', '%'.$search.'%');
            });
        }

        if(!empty($request->tag)){
            $blog_obj->join('blog_tags','blogs.id','=','blog_tags.blog_id')
            ->where('blog_tags.tag_id',$request->tag);
        }

        $blogs = $blog_obj->orderBy('blogs.created_at','desc')->paginate(5);

        if($blogs){
            $blogs = $blogs->toArray();
        }else{
            $blogs = [];
        }

        return view('front.blog_list_data', compact('blogs'));
    }

    public function singleBlog(Request $request,$id)
    {
        $blog_obj = Blog::where('status','A');
        $blog = $blog_obj->where('id',$id)->first();

        if($blog){
            $blog = $blog->toArray();
        }else{
            $blog = [];
        }


        $blog_obj = Blog::where('status','A');
        $blogs = $blog_obj->orderBy('created_at','desc')->take(4)->get();

        if($blogs){
            $blogs = $blogs->toArray();
        }else{
            $blogs = [];
        }

        return view('front.blog_single', compact('blog','blogs'));
    }

    public function termsofservice()
    {
        return view('front.terms_of_service');
    }

    public function privacypolicy()
    {
        return view('front.privacy_policy');
    }

    public function login()
    {
        return view('front.login');
    }

    public function forgotPassword()
    {
        return view('front.forgot-password');
    }

    public function maptest()
    {
        return view('maptest');
    }

    public function maptest1()
    {
        return view('maptest1');
    }
}
