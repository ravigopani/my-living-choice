<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Updater;

class Blog extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='blogs';
    protected $guarded = [];

    public static function saveBlog($data,$id='')
    {
        $save_data = [];
        array_key_exists('title',$data) ? $save_data['title'] = $data['title'] : '';
        array_key_exists('image',$data) ? $save_data['image'] = $data['image'] : '';
        array_key_exists('short_description',$data) ? $save_data['short_description'] = $data['short_description'] : '';
        array_key_exists('long_description',$data) ? $save_data['long_description'] = $data['long_description'] : '';
        
        if($id == '')
        {
            $result = Blog::create($save_data);
            if ($result){
                return ['id'=>$result->id,'message'=>'Blog added successfully.'];
            }
        }
        else
        {
            $result = Blog::where('id',$id)->update($save_data);
            if($result){
                return ['id'=>$id,'message'=>'Blog updated successfully.'];;
            }
        }
    }

    public static function getBlog($id=''){
        
        $queryObj = Blog::select('blogs.*');

        if($id!=''){
            $queryObj->where('blogs.id',$id);
        }

        $result = $queryObj->get()->first();

        return $result;
    }
}
