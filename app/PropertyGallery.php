<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Updater;

class PropertyGallery extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='property_gallery';
    protected $guarded = [];

    public static function savePropertyGallery($data,$id='')
    {
    	$save_data = [];
    	array_key_exists('property_id',$data) ? $save_data['property_id'] = $data['property_id'] : '';
    	array_key_exists('file_path',$data) ? $save_data['file_path'] = $data['file_path'] : '';

    	if($id == '')
    	{
    		$result = PropertyGallery::create($save_data);
    		if ($result){
    			return ['id'=>$result->id,'message'=>'Gallery image added successfully.'];
    		}
    	}
    	else
    	{
    		$result = PropertyGallery::where('id',$id)->update($save_data);
    		if($result){
    			return ['id'=>$id,'message'=>'Gallery image updated successfully.'];;
    		}
    	}
    }

    public static function getPropertyGallery($id=''){
    	
    	$queryObj = PropertyGallery::select('property_gallery.*');

    	if($id!=''){
    		$queryObj->where('property_gallery.id',$id);
    	}

    	$result = $queryObj->get()->first();

    	return $result;
    }
}
