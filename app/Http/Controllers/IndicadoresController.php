<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IndicadoresProyecto;

class IndicadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyecto=1;
        return view("indicadores.create",compact('proyecto'));
    }

    public function segunproyecto($proyecto){
        $retorno=IndicadoresProyecto::obtener_indicadores($proyecto);
        return $retorno;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $retorno=IndicadoresProyecto::guardar($request->All());

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
        $retorno=IndicadoresProyecto::modal_editar($id);
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
        $retorno=IndicadoresProyecto::editar($request,$id);
        return $retorno;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $retorno=IndicadoresProyecto::eliminar($id);
        return $retorno;
    }

    public function completado(Request $request){
       $retorno=IndicadoresProyecto::completado($request->id);
       return $retorno;
    }
}
