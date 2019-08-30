<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presupuestounidaddetalle;
use App\MaterialUnidad;

class PresupuestoUnidadDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try{
            $pre=Presupuestounidaddetalle::create($request->All());
           for($i=0;$i<(int)$request->cantidad;$i++){
               MaterialUnidad::create([
                'id'=>MaterialUnidad::retornar_id(),
                'presupuestounidad_id'=>$pre->id,
                'material_id'=>$request->material_id,
               ]);
           }
            return array(1,"exito",$request->All());
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
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
        $retorno=Presupuestounidaddetalle::modal_editar($id);
        return $retorno;
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
        $detalle=Presupuestounidaddetalle::find($id);
        $detalle->fill($request->all());
        $detalle->save();
        return array(1,"exito");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $detalle=Presupuestounidaddetalle::find($id);
            $detalle->delete();
            return array(1,"exito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }
}
