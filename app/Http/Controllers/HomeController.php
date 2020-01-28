<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuracion;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Auth;
class HomeController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configuracion=Configuracion::first();
        if($configuracion!='')
        {
            return view('home');
        }else{
            return redirect('configuraciones');
        }
        
    }

    public function autorizacion(Request $request)
    {
        $this->validacion($request->all())->validate();
        if (Auth::once(['username' => $request->username, 
            'password' => $request->password,'estado' => 1])
            ) {
                sleep(3);
            return array(1,"exito",Auth()->user()->hasRole('admin'));
        }else{
            return array(-1,"error");
        }
        
    }

    protected function validacion($data)
    {
        $mensajes=array(
            'username.required'=>'El nombre de usuario el obligatorio',
            'password.required'=>'La contraseña es obligatoria',
        );
        return Validator::make($data, [
            'username' => 'required',
            'password' => 'required',

        ],$mensajes);
    }
}
