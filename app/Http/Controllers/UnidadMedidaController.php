<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnidadMedida;
use App\Http\Requests\UnidadMedidaRequest;

class UnidadMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidadmedidas = UnidadMedida::orderby('nombre_medida')->get();
        return view('unidadmedidas.index',compact('unidadmedidas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidadmedidas = UnidadMedida::all();
        return view('unidadmedidas.create',compact('unidadmedidas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnidadMedidaRequest $request)
    {
        if($request->ajax()){
          try{
            $unidad=UnidadMedida::create($request->All());
            return array(1,"exito",$unidad);
          }catch(Exception $e){
              return array(-1,"error",$e->getMessage());
          }
        }else{
          UnidadMedida::create($request->All());
          return redirect('unidadmedidas')->with('mensaje','Unidad de medida creado exitosamente');
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
        try{
            $unidad=UnidadMedida::find($id);
            return array(1,"exito",$unidad);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnidadMedidaRequest $request, $id)
    {
        try{
            $unidad=UnidadMedida::find($id);
            if(!$request->nombre_medida==$unidad->nombre_medida):
            $unidad->fill($request->all());
            endif;
            return array(1,"exito");
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
        $unidad=UnidadMedida::find($id);
        $materiales=$unidad->material->count();
        if($materiales==0){
            $unidad->delete();
            return array(1,1,"Unidad de medida eliminada con éxito");
        }else{
            return array(1,2,"La unidad de medida tiene materiales");
        }

    }
}
