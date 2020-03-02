<?php

namespace App\Http\Controllers;
use App\Bitacora;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$bitacoras = Bitacora::join('users','bitacoras.idusuario','=','users.id')->paginate(10);
        $usuarios = \App\User::all();
        return view('bitacoras.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function general(Request $request)
    {
      if($request->ajax())
      {
        if($request->get('dia'))
        {
          $dia=invertir_fecha($request->get('dia'));
          $bitacoras = Bitacora::pordia($dia);
          return $bitacoras;
          //dd($bitacoras);
        }else{
          if($request->get('usuario')){
            $usuario=$request->get('usuario');
            $bitacoras = Bitacora::porempleado($usuario);
            return $bitacoras;
            //dd($bitacoras);
          }else{
            if($request->get('inicio') && $request->get('fin')){
              $inicio=invertir_fecha($request->get('inicio'));
              $fin=invertir_fecha($request->get('fin'));
              $bitacoras = Bitacora::porperiodo($inicio,$fin);
              return $bitacoras;
            }else{
              $bitacoras = Bitacora::all()->with('user');
            }
          }
        }
        return response()->json([
          "mensaje" => $bitacoras,
        ]);
      }else{
        if($request->get('dia'))
        {
          $dia=invertir_fecha($request->get('dia'));
          $bitacoras = Bitacora::where('registro',$dia)->get();
          //dd($bitacoras);
        }else{
          if($request->get('usuario')){
            $usuario=$request->get('usuario');
            $bitacoras = Bitacora::where('user_id',$usuario)->get();
            //dd($bitacoras);
          }else{
            if($request->get('inicio') && $request->get('fin')){
              $inicio=invertir_fecha($request->get('inicio'));
              $fin=invertir_fecha($request->get('fin'));
              $bitacoras = Bitacora::where('registro','>=',$inicio)->where('registro','<=',$fin)->get();
            }else{
              $diahoy=date("Y-m-d");
              
              $bitacoras = Bitacora::all();
            }
          }
        }
        //$dia=invertir_fecha($request->get('dia'));
        $usuarios = \App\User::where('estado',1)->get();
        $ultimo=Bitacora::orderBy('id', 'asc')->first();
        return view('bitacoras.general', compact('bitacoras','usuarios','ultimo'));
      }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function usuario(Request $request)
    {
        $usuario=$request->usuario;
       // dd($usuario);
        $bitacoras = Bitacora::where('idusuario',$usuario)->paginate(10);
        return view('bitacoras.usuario', compact('bitacoras'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fecha()
    {
        return view('bitacoras.fecha');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
