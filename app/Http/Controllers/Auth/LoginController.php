<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Bitacora;
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

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function username()
    {
        return 'username';
    }


    public function authenticate(Request $request)
    {
        //dd(bcrypt($request->password));
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            //dd('hola');
            Bitacora::bitacora('inicio sesion');
            return redirect()->intended('home');
        }else{
            return redirect('login')->with('error','El nombre de usuario o contraseña no existe en nuestros registros');
        }
    }

    public function logout()
    {
        Bitacora::bitacora('Cerró Sesión');
        Auth::logout();
        return redirect('login')->with('mensaje','Cerró Sesión del sistema exitósamente');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }


}
