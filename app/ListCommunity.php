<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Updater;

class ListCommunity extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='list_community';
    protected $guarded = [];

    public static function saveListCommunity($data)
    {
    	$save_data = [];
    	array_key_exists('name',$data) ? $save_data['name'] = $data['name'] : '';
    	array_key_exists('phone',$data) ? $save_data['phone'] = $data['phone'] : '';
        array_key_exists('email',$data) ? $save_data['email'] = $data['email'] : '';
        array_key_exists('website',$data) ? $save_data['website'] = $data['website'] : '';
        array_key_exists('paid_advertising',$data) ? $save_data['paid_advertising'] = $data['paid_advertising'] : '';

        $result = ListCommunity::create($save_data);
        if ($result){
            return ['id'=>$result->id,'message'=>'Listed Community successfully.'];
        }
    }

    public static function getListCommunity($id=''){
    	
    	$queryObj = ListCommunity::select('list_community.*');

    	if($id!=''){
    		$queryObj->where('list_community.id',$id);
    	}

    	$result = $queryObj->get()->first();

    	return $result;
    }
}
