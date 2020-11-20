<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CargoRequest;
use App\Cargo;
use Validator;

class CargoController extends Controller
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

    public function get()
    {
      $cargos = Cargo::get();
      return response()->json([

         'cargos'    => $cargos,

     ], 200);
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            return Cargo::where('estado',1)->get();
        }
        else{
            $estado = $request->get('estado');
        if($estado == "")$estado = 1;
        if($estado == 1)
        {
            $cargos = Cargo::where('estado', $estado)->get();
            return view('cargos.index',compact('cargos','estado'));
        }
        if($estado == 2)
        {
            $cargos = Cargo::where('estado',$estado)->get();
            return view('cargos.index',compact('cargos','estado'));
        }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cargos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validar($request->all())->validate();
        $cargo=Cargo::create([
            'cargo'=>$request->cargo,
            'catcargo_id'=>$request->catcargo_id
        ]);
        return array(1,"éxito",$cargo);
    }

    protected function validar(array $data)
    {
        $mensaje = array(
            'cargo.required'=>'El cargo es obligatorio',
            'catcargo_id.required'=>'La categoría es obligatoria'
        );
        return Validator::make($data, [
            'cargo' => 'required|unique:cargos',
            'catcargo_id' => 'required',
        ], $mensaje);
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
        $cargo = Cargo::find($id);
        return array(1,"exitoso",$cargo);
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
        $cargo = Cargo::find($id);
        $cargo->cargo=$request->cargo;
        $cargo->catcargo_id=$request->catcargo_id;
           // $this->validate($request,['cargo'=> 'required|unique:cargos|min:5']);
        $cargo->save();
        return array(1,"éxito",$cargo);
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

        $cargo = Cargo::find($id);
        if($cargo->detalleplanilla->count() == 0):
            $cargo->estado = 2;
            $cargo->save();
            bitacora('Dió de baja cargo');
            return redirect('/cargos')->with('mensaje','Cargo dado de baja');
        else: 
            return redirect('/cargos')->with('info','El cargo posee contratos activos, no debe eliminarse');
        endif;
    }

    public function alta($id)
    {
        $cargo = Cargo::find($id);
        $cargo->estado = 1;
        $cargo->motivo = "";
        $cargo->save();
        Bitacora:bitacora('Dió de alta un cargo');

        return redirect('/cargos')->with('mensaje', 'Cargo dado de alta');
    }
}
