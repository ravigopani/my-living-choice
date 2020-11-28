<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Common;
use App\Blog;
use App\Tag;
use App\BLogTag;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    public function index(Request $request)
    {
    	return view('admin.blog.base');
    }

    public function list(Request $request)
    {
        if(app('request')->exists('reset') && $request->reset==true)
        {
            Session::forget('search_blog');
            Session::forget('blog_field');
            Session::forget('blog_sort');
            Session::forget('blog_show');
        }

        Session::put('search_blog', $request->has('ok') ? $request->search : (Session::has('search_blog') ? Session::get('search_blog') : ''));
        Session::put('blog_show', $request->has('show') ? $request->show : (Session::has('blog_show') ? Session::get('blog_show') : '10'));
        Session::put('blog_field', $request->has('field') ? $request->field : (Session::has('blog_field') ? Session::get('blog_field') : 'id'));
        Session::put('blog_sort', $request->has('sort') ? $request->sort : (Session::has('blog_sort') ? Session::get('blog_sort') : 'desc'));

        $search_box = Session::get('search_blog');
        $show = Session::get('blog_show');

        $query = Blog::select('blogs.*');
        if($search_box != ''){       
            $query->where(function($q) use ($search_box){
                $q->where('blogs.title', 'LIKE', '%'.$search_box.'%')
                ->orwhere('blogs.short_description', 'LIKE', '%'.$search_box.'%')
                ->orwhere('blogs.long_description', 'LIKE', '%'.$search_box.'%');
            });
        }

        $blogs = $query->orderBy(Session::get('blog_field'), Session::get('blog_sort'))->paginate($show);

        if($blogs) {
            return view('admin.blog.list',compact('blogs'));
        }else{
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function create(Request $request)
    {
        $tags = Tag::where('status','A')->get()->toArray();
        return view('admin.blog.add_edit',compact('tags'));
    }

    public function edit(Request $request,$id)
    {
        $blog = Blog::getBlog($id);
        if(!$blog) {
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
        $tags = Tag::where('status','A')->get()->toArray();
        $blog_tags = BLogTag::where('blog_id',$id)->get()->toArray();
        return view('admin.blog.add_edit',compact('blog','tags','blog_tags'));
    }

    public function store(Request $request)
    {
        $validate['title']='required|max:256';
        $validate['short_description']='required';
        $validate['long_description']='required';
        $validatedData=$request->validate($validate);

        $save_data['title']=$request->title;
        $save_data['short_description']=$request->short_description;
        $save_data['long_description']=$request->long_description;

        if (!file_exists(storage_path('/blogPicture'))) {
            mkdir(storage_path('/blogPicture'), 0777, true);
        }

        $image_path = '';
        if($request->file('image'))
        {
            $image = $request->file('image');
            $image_path = time().'-'.$image->getClientOriginalName();
            $destinationPath = storage_path('/blogPicture');
            $image->move($destinationPath, $image_path);
        }

        if($image_path  != ''){
            $save_data['image'] = $image_path;
        }
        
        $result = Blog::saveBlog($save_data);
        if($result)
        {
            if(!empty($request->tags))
            {
                foreach ($request->tags as $value) 
                {
                    BLogTag::saveBlogTag(['blog_id'=>$result['id'], 'tag_id'=>$value]);
                }
            }

            return redirect(\Config::get('constants.ADMIN_URL').'blog')->with(['status'=>'success','message'=>$result['message']]);
        }
        else
        {
            return Redirect::back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function update(Request $request,$id)
    {
        $validate['title']='required|max:256';
        $validate['short_description']='required';
        $validate['long_description']='required';
        $validatedData=$request->validate($validate);

        $save_data['title']=$request->title;
        $save_data['short_description']=$request->short_description;
        $save_data['long_description']=$request->long_description;

        if (!file_exists(storage_path('/blogPicture'))) {
            mkdir(storage_path('/blogPicture'), 0777, true);
        }

        $image_path = '';
        if($request->file('image'))
        {
            $image = $request->file('image');
            $image_path = time().'-'.$image->getClientOriginalName();
            $destinationPath = storage_path('/blogPicture');
            $image->move($destinationPath, $image_path);
        }

        if($image_path  != ''){
            $save_data['image'] = $image_path;
        }

        $blog_tags = BlogTag::where('blog_id',$id)->get()->toArray();

        $old_blog_tags = [];
        if(!empty($blog_tags)){
            foreach ($blog_tags as $key => $value) {
                $old_blog_tags[] = $value['tag_id'];
            }
        }

        $add_record = $delete_record = [];
        $delete_record = array_diff($old_blog_tags,$request->tags);
        $add_record = array_diff($request->tags,$old_blog_tags);

        if(!empty($add_record))
        {
            foreach ($add_record as $value) 
            {
                $result = BlogTag::saveBlogTagWithExistCheck($id,$value);
            }
        }

        if(!empty($delete_record))
        {
            foreach ($delete_record as $value) 
            {
                $result = BlogTag::deleteBlogTag($id,$value);
            }
        }

        $result = Blog::saveBlog($save_data,$id);
        if($result)
        {
            return redirect(\Config::get('constants.ADMIN_URL').'blog/'.$result['id'].'/edit')->with(['status'=>'success','message'=>$result['message']]);
        }
        else
        {
            return Redirect::back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }
}
