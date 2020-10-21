<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Updater;
use App\Care;

class PropertyCare extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='property_cares';
    protected $guarded = [];

    public function care_detail()
    {
        return $this->hasOne(Care::class, 'id', 'care_id');
    }

    public static function savePropertyCare($data,$id='')
    {
    	$save_data = [];
    	array_key_exists('property_id',$data) ? $save_data['property_id'] = $data['property_id'] : '';
    	array_key_exists('care_id',$data) ? $save_data['care_id'] = $data['care_id'] : '';

    	if($id == '')
    	{
    		$result = PropertyCare::create($save_data);
    		if ($result){
    			return ['id'=>$result->id,'message'=>'Property care added successfully.'];
    		}
    	}
    	else
    	{
    		$result = PropertyCare::where('id',$id)->update($save_data);
    		if($result){
    			return ['id'=>$id,'message'=>'Property care updated successfully.'];;
    		}
    	}
    }

    public static function savePropertyCareWithExistCheck($property_id,$care_id)
    {
        $property_care = PropertyCare::where('property_id',$property_id)
                    ->where('care_id',$care_id)
                    ->withTrashed()->get()->toArray();

        if(!empty($property_care)){
            $property_care = PropertyCare::where('property_id',$property_id)
                    ->where('care_id',$care_id)
                    ->withTrashed()->restore();
        }else{
            $save_data = [];
            $save_data['property_id'] = $property_id;
            $save_data['care_id'] = $care_id;
            $property_care = PropertyCare::create($save_data);
        }
        return $property_care;
    }

    public static function deletePropertyCare($property_id,$care_id)
    {
        return PropertyCare::where('property_id',$property_id)
                    ->where('care_id',$care_id)->delete();
    }

    public static function getPropertyCare($id=''){
    	
    	$queryObj = PropertyCare::select('property_cares.*');

    	if($id!=''){
    		$queryObj->where('property_cares.id',$id);
    	}

    	$result = $queryObj->get()->first();

    	return $result;
    }
}
