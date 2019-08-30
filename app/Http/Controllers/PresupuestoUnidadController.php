<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;
use App\Presupuestounidad;
use App\Presupuestounidaddetalle;
use App\MaterialUnidad;

class PresupuestoUnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presupuestos = Presupuestounidad::where('estado',1)->get();
        return view('unidades.presupuestos.index',compact('presupuestos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidades = Unidad::where('estado',1)->get();
        return view('unidades.presupuestos.create',compact('unidades'));
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
        $presupuestounidad = Presupuestounidad::create([
            'unidad_id' => $request->unidad_admin,
            'anio' => $request->anio,
            'user_id'=>Auth()->user()->id
        ]);
        
        return array(1,"exito",$presupuestounidad->id);
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
        $presupuesto = Presupuestounidad::findorFail($id);
        return view('unidades.presupuestos.show',compact('presupuesto'));
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

    public function materiales($id)
    {
      $retorno=Presupuestounidad::materiales($id);
      return $retorno;
    }
}
