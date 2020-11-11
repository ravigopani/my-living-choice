<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Updater;

class Care extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='cares';
    protected $guarded = [];

    public static function saveCare($data,$id='')
    {
    	$save_data = [];
    	array_key_exists('care',$data) ? $save_data['care'] = $data['care'] : '';
    	array_key_exists('status',$data) ? $save_data['status'] = $data['status'] : '';

    	if($id == '')
    	{
    		$result = Care::create($save_data);
    		if ($result){
    			return ['id'=>$result->id,'message'=>'Care added successfully.'];
    		}
    	}
    	else
    	{
    		$result = Care::where('id',$id)->update($save_data);
    		if($result){
    			return ['id'=>$id,'message'=>'Care updated successfully.'];;
    		}
    	}
    }

    public static function getCare($id=''){
    	
    	$queryObj = Care::select('cares.*');

    	if($id!=''){
    		$queryObj->where('cares.id',$id);
    	}

    	$result = $queryObj->get()->first();

    	return $result;
    }
}
