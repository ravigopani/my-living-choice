<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type', 'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function saveUser($data,$id='')
    {
        $save_data = [];
        array_key_exists('name',$data) ? $save_data['name'] = $data['name'] : '';
        array_key_exists('email',$data) ? $save_data['email'] = $data['email'] : '';
        array_key_exists('password',$data) ? $save_data['password'] = $data['password'] : '';
        array_key_exists('user_type',$data) ? $save_data['user_type'] = $data['user_type'] : '';
        array_key_exists('profile_image',$data) ? $save_data['profile_image'] = $data['profile_image'] : '';
        
        if($id == '')
        {
            $result = User::create($save_data);
            if ($result){
                return ['id'=>$result->id,'message'=>'User added successfully.'];
            }
        }
        else
        {
            $result = User::where('id',$id)->update($save_data);
            if($result){
                return ['id'=>$id,'message'=>'User updated successfully.'];;
            }
        }
    }

    public static function getUser($id=''){
        
        $queryObj = User::select('users.*');

        if($id!=''){
            $queryObj->where('users.id',$id);
        }

        $result = $queryObj->get()->first();

        return $result;
    }
}
