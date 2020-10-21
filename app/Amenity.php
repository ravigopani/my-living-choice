<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Updater;

class Amenity extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='amenties';
    protected $guarded = [];

    public static function saveAmenity($data,$id='')
    {
    	$save_data = [];
    	array_key_exists('amenity',$data) ? $save_data['amenity'] = $data['amenity'] : '';
    	array_key_exists('status',$data) ? $save_data['status'] = $data['status'] : '';

    	if($id == '')
    	{
    		$result = Amenity::create($save_data);
    		if ($result){
    			return ['id'=>$result->id,'message'=>'Amenity added successfully.'];
    		}
    	}
    	else
    	{
    		$result = Amenity::where('id',$id)->update($save_data);
    		if($result){
    			return ['id'=>$id,'message'=>'Amenity updated successfully.'];;
    		}
    	}
    }

    public static function getAmenity($id=''){
    	
    	$queryObj = Amenity::select('amenties.*');

    	if($id!=''){
    		$queryObj->where('amenties.id',$id);
    	}

    	$result = $queryObj->get()->first();

    	return $result;
    }
}
