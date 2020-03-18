<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Bitacora;
use App\Porcentaje;
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
        return view('Auth.login');
    }

    public function username()
    {
        return 'username';
    }


    public function authenticate(Request $request)
    {
        $porcentajes=Porcentaje::all();
        foreach($porcentajes as $p){
            session([$p->nombre_simple => $p->porcentaje/100]);
        }
        if (Auth::attempt(['username' => $request->username, 
            'password' => $request->password,'estado' => 1])
            ) {
            //dd('hola');
            Bitacora::bitacora('inicio de sesion');
            return redirect()->intended('home');
        }else{
            return redirect('/')->with('error','El nombre de usuario o contraseña no existe en nuestros registros');
        }
    }

    public function logout()
    {
        Bitacora::bitacora('Cerró Sesión del sistema');
        session()->flush();
        Auth::logout();
        return redirect('/')->with('mensaje','Cerró Sesión del sistema exitósamente');
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
