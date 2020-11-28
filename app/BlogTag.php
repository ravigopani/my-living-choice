<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Updater;
use App\Tag;

class BlogTag extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='blog_tags';
    protected $guarded = [];

    public function tag_detail()
    {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }

    public static function saveBlogTag($data,$id='')
    {
    	$save_data = [];
    	array_key_exists('blog_id',$data) ? $save_data['blog_id'] = $data['blog_id'] : '';
    	array_key_exists('tag_id',$data) ? $save_data['tag_id'] = $data['tag_id'] : '';

    	if($id == '')
    	{
    		$result = BlogTag::create($save_data);
    		if ($result){
    			return ['id'=>$result->id,'message'=>'Blog Tag added successfully.'];
    		}
    	}
    	else
    	{
    		$result = BlogTag::where('id',$id)->update($save_data);
    		if($result){
    			return ['id'=>$id,'message'=>'Blog Tag updated successfully.'];;
    		}
    	}
    }

    public static function saveBlogTagWithExistCheck($blog_id,$tag_id)
    {
        $blog_tag = BlogTag::where('blog_id',$blog_id)
                    ->where('tag_id',$tag_id)
                    ->withTrashed()->get()->toArray();

        if(!empty($blog_tag)){
            $blog_tag = BlogTag::where('blog_id',$blog_id)
                    ->where('tag_id',$tag_id)
                    ->withTrashed()->restore();
        }else{
            $save_data = [];
            $save_data['blog_id'] = $blog_id;
            $save_data['tag_id'] = $tag_id;
            $blog_tag = BlogTag::create($save_data);
        }
        return $blog_tag;
    }

    public static function deleteBlogTag($blog_id,$tag_id)
    {
        return BlogTag::where('blog_id',$blog_id)
                    ->where('tag_id',$tag_id)->delete();
    }

    public static function getBlogTag($id=''){
    	
    	$queryObj = BlogTag::select('blog_tags.*');

    	if($id!=''){
    		$queryObj->where('blog_tags.id',$id);
    	}

    	$result = $queryObj->get()->first();

    	return $result;
    }
}
