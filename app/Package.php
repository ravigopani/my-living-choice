<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Updater;

class Package extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='packages';
    protected $guarded = [];

    public static function savePackage($data,$id='')
    {
    	$save_data = [];
    	array_key_exists('package',$data) ? $save_data['package'] = $data['package'] : '';
    	array_key_exists('status',$data) ? $save_data['status'] = $data['status'] : '';

    	if($id == '')
    	{
    		$result = Package::create($save_data);
    		if ($result){
    			return ['id'=>$result->id,'message'=>'Package added successfully.'];
    		}
    	}
    	else
    	{
    		$result = Package::where('id',$id)->update($save_data);
    		if($result){
    			return ['id'=>$id,'message'=>'Package updated successfully.'];;
    		}
    	}
    }

    public static function getPackage($id=''){
    	
    	$queryObj = Package::select('packages.*');

    	if($id!=''){
    		$queryObj->where('packages.id',$id);
    	}

    	$result = $queryObj->get()->first();

    	return $result;
    }
}
