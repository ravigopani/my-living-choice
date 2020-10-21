<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Updater;

class State extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='states';
    protected $guarded = [];

    public static function saveState($data,$id='')
    {
    	$save_data = [];
    	array_key_exists('state',$data) ? $save_data['state'] = $data['state'] : '';
    	array_key_exists('status',$data) ? $save_data['status'] = $data['status'] : '';

    	if($id == '')
    	{
    		$result = State::create($save_data);
    		if ($result){
    			return ['id'=>$result->id,'message'=>'State added successfully.'];
    		}
    	}
    	else
    	{
    		$result = State::where('id',$id)->update($save_data);
    		if($result){
    			return ['id'=>$id,'message'=>'State updated successfully.'];;
    		}
    	}
    }

    public static function getState($id=''){
    	
    	$queryObj = State::select('states.*');

    	if($id!=''){
    		$queryObj->where('states.id',$id);
    	}

        if($id!=''){
            $result = $queryObj->get()->first();
        }else{
            $result = $queryObj->get();
        }

    	return $result;
    }
}
