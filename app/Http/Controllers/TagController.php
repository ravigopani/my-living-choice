<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function index(Request $request)
    {
    	return view('admin.tag.tag');
    }

    public function list(Request $request)
    {
        if(app('request')->exists('reset') && $request->reset==true)
        {
            Session::forget('search_tag');
            Session::forget('tag_field');
            Session::forget('tag_sort');
            Session::forget('tag_show');
        }

        Session::put('search_tag', $request->has('ok') ? $request->search : (Session::has('search_tag') ? Session::get('search_tag') : ''));
        Session::put('tag_show', $request->has('show') ? $request->show : (Session::has('tag_show') ? Session::get('tag_show') : '10'));
        Session::put('tag_field', $request->has('field') ? $request->field : (Session::has('tag_field') ? Session::get('tag_field') : 'id'));
        Session::put('tag_sort', $request->has('sort') ? $request->sort : (Session::has('tag_sort') ? Session::get('tag_sort') : 'desc'));

        $search_box = Session::get('search_tag');

        $query = Tag::select('tags.*');
        if($search_box != ''){       
            $query->where(function($q) use ($search_box){
                $q->where('tags.tag', 'LIKE', '%'.$search_box.'%')
                ->orwhere('tags.created_at', 'LIKE', '%'.$search_box.'%')
                ->orwhere('tags.updated_at', 'LIKE', '%'.$search_box.'%');
            });
        }

        $tags = $query->orderBy(Session::get('tag_field'), Session::get('tag_sort'))
                        ->paginate(Session::get('tag_show'));

        if($tags) {
            return view('admin.tag.list',compact('tags'));
        }else{
            return back()->with(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function edit(Request $request,$id)
    {
        $tags = Tag::getTag($id);
        if($tags) {
            return response()->json($tags);
        }
        else{
            return response()->json(['status'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function store(Request $request)
    {
        if(!empty($request->id)){
            $validate['tag']="required|unique:tags,tag,$request->id,id,deleted_at,NULL|max:128";
        }else{
            $validate['tag']="required|unique:tags|max:128";
        }
        
        $validatedData = $request->validate($validate);

        $save_data['tag']=$request->tag;
                        
        $result = Tag::saveTag($save_data,$request->id);
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
