<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Updater;

class ContactUs extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='contact_us';
    protected $guarded = [];

    public static function saveContactUs($data)
    {
    	$save_data = [];
    	array_key_exists('first_name',$data) ? $save_data['first_name'] = $data['first_name'] : '';
    	array_key_exists('last_name',$data) ? $save_data['last_name'] = $data['last_name'] : '';
        array_key_exists('phone_number',$data) ? $save_data['phone_number'] = $data['phone_number'] : '';
        array_key_exists('email',$data) ? $save_data['email'] = $data['email'] : '';
        array_key_exists('message',$data) ? $save_data['message'] = $data['message'] : '';

        $result = ContactUs::create($save_data);
        if ($result){
            return ['id'=>$result->id,'message'=>'Contact request sent successfully.'];
        }
    }

    public static function getContactUs($id=''){
    	
    	$queryObj = ContactUs::select('contact_us.*');

    	if($id!=''){
    		$queryObj->where('contact_us.id',$id);
    	}

    	$result = $queryObj->get()->first();

    	return $result;
    }
}
