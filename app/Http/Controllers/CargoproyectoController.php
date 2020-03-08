<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CargoProyecto;
use Validator;

class CargoproyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargos=CargoProyecto::where('estado',1)->get();
        return view('proyectos.cargos.index',compact('cargos'));
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
        $this->validar($request->all())->validate();
        try{
            $cargo=CargoProyecto::create([
                'id'=>date("Yidisus"),
                'nombre'=>$request->nombre,
                'salario_dia'=>$request->salario_dia
            ]);
            return array(1,"éxito",$cargo);
        }catch(Exception $e){
            return array(-1,"éxito",$e->getMessage());
        }
    }

    protected function validar(array $data)
    {
        $mensajes=array(
            'nombre.required'=>'El nombre es obligatorio',
            'nombre.unique'=>'El nombre de cargo ya esta en uso',
            'salario_dia.required'=>'El salario por día es obligatorio',
        );
        return Validator::make($data, [
            'nombre' => 'required|unique:cargo_proyectos',
            'salario_dia' => 'required',
        ],$mensajes);
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
        $cargo=CargoProyecto::find($id);
        return array(1,"éxito",$cargo);
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
            $cargo=CargoProyecto::find($id);
            $cargo->fill($request->all());
            $cargo->save();
            return array(1,"éxito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
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
}
