<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Updater;
use App\PropertyCare;
use App\Care;

class Property extends Model
{
    use SoftDeletes;
    use Updater;
    protected $table='properties';
    protected $guarded = [];

    public function cares(){
        return $this->hasMany(PropertyCare::class, 'property_id', 'id');
    }

    public static function saveProperty($data,$id='')
    {
        $save_data = [];
        array_key_exists('name',$data) ? $save_data['name'] = $data['name'] : '';
        array_key_exists('name',$data) ? $save_data['name'] = $data['name'] : '';
        array_key_exists('website',$data) ? $save_data['website'] = $data['website'] : '';
        array_key_exists('owner_id',$data) ? $save_data['owner_id'] = $data['owner_id'] : '';
        array_key_exists('address',$data) ? $save_data['address'] = $data['address'] : '';
        array_key_exists('state_id',$data) ? $save_data['state_id'] = $data['state_id'] : '';
        array_key_exists('city_id',$data) ? $save_data['city_id'] = $data['city_id'] : '';
        array_key_exists('zip',$data) ? $save_data['zip'] = $data['zip'] : '';
        array_key_exists('latitude',$data) ? $save_data['latitude'] = $data['latitude'] : '';
        array_key_exists('longitude',$data) ? $save_data['longitude'] = $data['longitude'] : '';
        array_key_exists('phone_number',$data) ? $save_data['phone_number'] = $data['phone_number'] : '';
        array_key_exists('call_tracking_phone_number',$data) ? $save_data['call_tracking_phone_number'] = $data['call_tracking_phone_number'] : '';
        array_key_exists('contact_name',$data) ? $save_data['contact_name'] = $data['contact_name'] : '';
        array_key_exists('contact_email',$data) ? $save_data['contact_email'] = $data['contact_email'] : '';   
        array_key_exists('facebook_link',$data) ? $save_data['facebook_link'] = $data['facebook_link'] : '';
        array_key_exists('linkedin_link',$data) ? $save_data['linkedin_link'] = $data['linkedin_link'] : '';
        array_key_exists('twitter_link',$data) ? $save_data['twitter_link'] = $data['twitter_link'] : '';
        array_key_exists('instagram_link',$data) ? $save_data['instagram_link'] = $data['instagram_link'] : '';
        array_key_exists('short_description',$data) ? $save_data['short_description'] = $data['short_description'] : '';
        array_key_exists('long_description',$data) ? $save_data['long_description'] = $data['long_description'] : '';
        array_key_exists('year_opened',$data) ? $save_data['year_opened'] = $data['year_opened'] : '';
        array_key_exists('starting_price',$data) ? $save_data['starting_price'] = $data['starting_price'] : '';
        array_key_exists('total_units',$data) ? $save_data['total_units'] = $data['total_units'] : '';
        array_key_exists('package_id',$data) ? $save_data['package_id'] = $data['package_id'] : '';
        array_key_exists('amenities',$data) ? $save_data['amenities'] = $data['amenities'] : '';
        array_key_exists('show_in_list',$data) ? $save_data['show_in_list'] = $data['show_in_list'] : '';
        array_key_exists('header_image',$data) ? $save_data['header_image'] = $data['header_image'] : '';
        array_key_exists('logo_image',$data) ? $save_data['logo_image'] = $data['logo_image'] : '';

        if($id == '')
        {
            $result = Property::create($save_data);
            if ($result){
                return ['id'=>$result->id,'message'=>'Property added successfully.'];
            }
        }
        else
        {
            $result = Property::where('id',$id)->update($save_data);
            if($result){
                return ['id'=>$id,'message'=>'Property updated successfully.'];;
            }
        }
    }

    public static function getProperty($id=''){
        
        $queryObj = Property::select('properties.*');

        if($id!=''){
            $queryObj->where('properties.id',$id);
        }

        $result = $queryObj->get()->first();

        return $result;
    }
}
