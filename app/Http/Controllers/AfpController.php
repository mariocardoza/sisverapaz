<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\afp;
use Validator;

class AfpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->estado=='')
        $estado=1;
        else
        $estado=$request->estado;

        $afps=afp::where('estado',$estado)->get();
        //dd($afps);
        return view("afps.index",compact('afps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $retorno=afp::guardar($request->All());
        return $retorno;
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
        $afp = Afp::find($id);
        return array(1,"exitoso",$afp);
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
        try{
            $afp = Afp::find($id);
        if($afp->nombre!= $request->nombre)
        {
            $this->validate($request,['nombre'=> 'required|unique:afps|min:5']);
        }
        $afp->nombre = $request->nombre;
        $afp->save();
        return array(1,"éxito");
        } catch(exception $e){
            return array(-1);
        }
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
        $id=$datos[0];
        //$motivo=$datos[1];
        $afp = Afp::find($id);
        if($afp->empleado->count() == 0):
            $afp->estado= 2;
            //$banco->motivo=$motivo;
            //$banco->fechabaja=date('Y-m-d');
            $afp->save();
            bitacora('Dió de baja a una afp');
            return redirect('/afps')->with('mensaje','Banco dado de baja');
        else: 
            return redirect('/afps')->with('info','El AFP ya esta asignado a empleados, no debe eliminarse');
        endif;

    }
    public function alta($id)
    {
        $banco = Afp::find($id);
        $banco->estado=1;
        //$banco->motivo=null;
       // $banco->fechabaja=null;
        $banco->save();
        bitacora('Dió de alta a un registro');
        return redirect('/afps')->with('mensaje','Registro dado de alta');
    }
}
