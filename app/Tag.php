<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Updater;

class Tag extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='tags';
    protected $guarded = [];

    public static function saveTag($data,$id='')
    {
    	$save_data = [];
    	array_key_exists('tag',$data) ? $save_data['tag'] = $data['tag'] : '';
    	array_key_exists('status',$data) ? $save_data['status'] = $data['status'] : '';

    	if($id == '')
    	{
    		$result = Tag::create($save_data);
    		if ($result){
    			return ['id'=>$result->id,'message'=>'Tag added successfully.'];
    		}
    	}
    	else
    	{
    		$result = Tag::where('id',$id)->update($save_data);
    		if($result){
    			return ['id'=>$id,'message'=>'Tag updated successfully.'];;
    		}
    	}
    }

    public static function getTag($id=''){
    	
    	$queryObj = Tag::select('tags.*');

    	if($id!=''){
    		$queryObj->where('tags.id',$id);
    	}

    	$result = $queryObj->get()->first();

    	return $result;
    }
}
