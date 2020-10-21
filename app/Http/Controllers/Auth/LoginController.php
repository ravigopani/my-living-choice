<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Company;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $cus_loginattempt = 1;

        if(Session::has('cus_loginattempt'))
        {
            if(Session::get('cus_loginattempt') > 7)
            {
                if(User::where('email',$request->email)->first())
                {
                    User::where('email',$request->email)->update(['status'=>'L']);
                }
            }
        }

        if (Session::has('cus_loginattempt') && Session::has('customer_captcha')) 
        {
            $this->validateLogin($request);
        }
        elseif(Session::has('cus_loginattempt'))
        {
            $this->validateLogin($request);

            $cus_loginattempt = Session::get('cus_loginattempt');
            $cus_logintime = Session::get('cus_logintime');

            if ($cus_loginattempt > 2 /*&& (time() - $cus_logintime <= 60)*/)
            {
                //return back()->with('customer_captcha',true);
                Session::put('customer_captcha','1');
                $captcha = $request->input('captcha');
            }
            /*if (time() - $cus_logintime > 60)
            {
                Session::put('cus_loginattempt', 1);
                Session::put('cus_logintime', time());
                Session::forget('customer_captcha');
            }*/
        }
        else
        {
            $this->validateLogin($request);

            Session::put('cus_loginattempt', $cus_loginattempt);
            Session::put('cus_logintime', time());
        }

        Session::put('cus_loginattempt', $cus_loginattempt + 1);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        if(Session::has('cus_loginattempt') && Session::has('customer_captcha')) 
        {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
                'captcha' => 'required|captcha',
            ]);
        }
        else
        {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/admin/login');
    }
}
