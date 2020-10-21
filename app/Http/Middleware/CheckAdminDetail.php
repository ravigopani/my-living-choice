<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;
use Illuminate\Support\Facades\Session;

class CheckAdminDetail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(!Session::get('profile_image') && Auth::user()->id){
            $user = User::where('id',Auth::user()->id)->first();
            Session::put('profile_image',$user->profile_image);
        }else{

        }

        return $next($request);
    }
}
