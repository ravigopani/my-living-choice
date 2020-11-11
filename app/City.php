<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Updater;

class City extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='cities';
    protected $guarded = [];

    public static function saveCity($data,$id='')
    {
    	$save_data = [];
    	array_key_exists('city',$data) ? $save_data['city'] = $data['city'] : '';
        array_key_exists('state_id',$data) ? $save_data['state_id'] = $data['state_id'] : '';
    	array_key_exists('status',$data) ? $save_data['status'] = $data['status'] : '';

    	if($id == '')
    	{
    		$result = City::create($save_data);
    		if ($result){
    			return ['id'=>$result->id,'message'=>'City added successfully.'];
    		}
    	}
    	else
    	{
    		$result = City::where('id',$id)->update($save_data);
    		if($result){
    			return ['id'=>$id,'message'=>'City updated successfully.'];;
    		}
    	}
    }

    public static function getCity($id=''){
    	
    	$queryObj = City::select('cities.*');

    	if($id!=''){
    		$queryObj->where('cities.id',$id);
    	}

    	$result = $queryObj->get()->first();

    	return $result;
    }
}
