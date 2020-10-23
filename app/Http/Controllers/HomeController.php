<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuracion;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Auth;
use DB;
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
        //$proyectos=null;
        
        $proyectos=DB::table('proyectos as p')
        ->select('p.id','p.nombre','p.beneficiarios','p.codigo_proyecto','p.direccion',
        'p.estado','p.fecha_inicio','p.fecha_fin','p.lat','p.lng','p.motivo','p.monto',
        DB::RAW('(select
            sum(ip.porcentaje)
        FROM
            indicadores_proyectos AS ip
        WHERE
            ip.proyectos_id = p.id
        AND ip.estado = 2) as avance'))
        ->where('p.anio','=',date('Y'))
        ->get();
        

        if($configuracion!='')
        {
            return view('home',compact('proyectos'));
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
