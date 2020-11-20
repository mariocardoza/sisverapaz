<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UnidadRequest;
use App\Unidad;
use Validator;

class UnidadAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
          return response(Unidad::where('estado',1)->get());
        }else{
          if($request->estado=='')
          $estado=1;
          else
          $estado=$request->estado;
          $unidades = Unidad::where('estado',$estado)->get();
          //dd($unidades);
          return view('unidades.index',compact('unidades'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unidades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnidadRequest $request)
    {
        if($request->ajax()){
          try{
            $unidad=Unidad::create($request->All());
            return array(1,'éxito',$unidad);
          }catch(\Exception $e){
            return array(-1, $e->getMessage());
          }
        }else{
          try
          {
            Unidad::create($request->All());
            return redirect('unidades')->with('mensaje','Unidad registrada con éxito');
          }catch(\Exception $e)
          {
            return redirect('unidades/create')->with('error','Ocurrió un error a registrar la unidad, contacte al administrador');
          }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unidad = Unidad::find($id);
        return array(1,"exitoso",$unidad);
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
        $unidad = Unidad::find($id);
        if($unidad->nombre_unidad!=$request->nombre_unidad){
            $this->validate($request,['nombre_unidad'=>'required|unique:unidads|min:4']);
        }
        $unidad->nombre_unidad = $request->nombre_unidad;
        $unidad->save();

        return array(1,"éxito");
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

    public function baja($cadena)
    {
        $datos = explode("+", $cadena);
        $id = $datos[0];
        $motivo = $datos[1];
        $unidad = Unidad::find($id);
        if($unidad->usuario->count() == 0):
          $unidad->motivo = $motivo;
          $unidad->fecha_baja = date('Y-m-d');
          $unidad->estado = 2;
          $unidad->save();
          bitacora('Dió de baja la unidad administrativa');
          return redirect('/unidades')->with('mensaje','Unidad dada de baja');
        else:
          //bitacora('Dió de baja la unidad administrativa');
          return redirect('/unidades')->with('info','Unidad posee usuarios no debe eliminarse');
        endif;
        
    }
    public function alta($id)
    {
        $unidad = Unidad::find($id);
        $unidad->estado = 1;
        $unidad->motivo = null;
        $unidad->fecha_baja = null;
        $unidad->save();
        bitacora('Dió de alta a un registro');
        return redirect('/unidades')->with('mensaje','Registro dado de alta');
    }
}
