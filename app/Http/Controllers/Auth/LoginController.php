<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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


    use AuthenticatesUsers{
        logout as protected originalLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function username()
    // {
    //     return 'username'; // اسم الحقل الذي من خلالة سيتم تسجيل الدخول
    // }


    // login using username or email
    public function username()
    {
        $field = (filter_var(request()->email, FILTER_VALIDATE_EMAIL) || !request()->email) ? 'email' : 'username';
        request()->merge([$field => request()->email]);
        return $field;
    }


    public function redirectTo(){
        if(auth()->user()->roles->first()->allowed_route != ''){
            return $this->redirectTo = auth()->user()->roles->first()->allowed_route . '/index';
        }
    }

    public function logout(Request $request)
    {
        $cart = collect($request->session()->get('cart'));

        /* Call original logout method  */
        $response = $this->originalLogout($request);

        /* Repopulate Session  */
        if(!config('cart.destroy_on_logout')){
            $cart->each(function ($rows ,$identifier) use ($request){
                $request->session()->put('cart.'. $identifier , $rows);
            });
        }

        /* Return Original Response */
        return $response;
    }

    


}
