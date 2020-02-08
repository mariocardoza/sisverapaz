<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requisiciondetalle;
use App\UnidadMedida;
use App\Http\Requests\RequisiciondetalleRequest;

class RequisiciondetalleController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
      $medidas=UnidadMedida::all();
        return view('requisiciones.detalle.create',compact('id','medidas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequisiciondetalleRequest $request)
    {
      try{
        if(intval($request->cantidad) > intval($request->disponible)){
          return array(2,"mensaje","La cantidad ingresada sobrepasa a lo disponible");
        }else{
          Requisiciondetalle::create([
            'requisicion_id'=>$request->requisicion_id,
            'cantidad'=>$request->cantidad,
            'unidad_medida'=>$request->unidad_medida,
            'materiale_id'=>$request->materiale_id,
            'id'=>Requisiciondetalle::retonrar_id_insertar()
        ]);
        return array(1,"exito",$request->requisicion_id);
        }
        
      }catch (\Exception $e){
        return array(-1,'error',$e->getMessage());
      }

    }

    public function guardar(RequisiciondetalleRequest $request)
    {
      try{
        
          Requisiciondetalle::create([
            'requisicion_id'=>$request->requisicion_id,
            'cantidad'=>$request->cantidad,
            'unidad_medida'=>$request->unidad_medida,
            'materiale_id'=>$request->materiale_id,
            'id'=>Requisiciondetalle::retonrar_id_insertar()
        ]);
        return array(1,"exito",$request->requisicion_id);
        
        
      }catch (\Exception $e){
        return array(-1,'error',$e->getMessage());
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
        $modal="";

        try{
            $requisicion=Requisiciondetalle::findorFail($id);
            $medidas=UnidadMedida::all();
            $modal.='<div class="modal fade" data-backdrop="static" data-keyboard="false" id="elmodal_editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Necesidad de la requisicion</h4>
                    </div>
                    <div class="modal-body">
                    <input type="hidden" id="elcodigo_detalle" name="requisicion_id" value="'.$requisicion->id.'">
                      <form id="form_editar_eldetalle" class="form-horizontal">
                        
                        <div class="form-group">
                          <label for="" class="col-md-4 control-label">Descripcion</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="'.$requisicion->material->nombre.'"> 
                            </div>
                        </div>

                        <div class="form-group">
                          <label for="" class="col-md-4 control-label">Unidad de medida</label>
                          <div class="col-md-6">
                          <select class="chosen-select-width">';
                          foreach ($medidas as $medida):
                             if($medida->id==$requisicion->unidad_medida):
                                $modal.='<option selected value="'.$medida->id.'">'.$medida->nombre_medida.'</option>';
                            else:
                                $modal.='<option value="'.$medida->id.'">'.$medida->nombre_medida.'</option>';
                            endif;
                          endforeach;
                          $modal.='</select> 
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="" class="col-md-4 control-label">Cantidad</label>
                            <div class="col-md-6">
                            <input type="hidden" value="'.$requisicion->requisicion_id.'" name="requisicion_id">
                            <input type="text" name="cantidad" class="form-control" value="'.$requisicion->cantidad.'"> 
                              
                            </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      <button type="button" id="editar_eldetalle" class="btn btn-success">Agregar</button></center>
                    </div>
                  </div>
                  </div>
                </div>';
            return array(1,"exito",$requisicion,$modal);
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
    public function update(RequisiciondetalleRequest $request,$id)
    {
        try{
            $requisiciondetalle=Requisiciondetalle::findorFail($id);
            $requisiciondetalle->fill($request->All());
            $requisiciondetalle->save();
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
    public function destroy(Requisiciondetalle $requisiciondetalle)
    {
      try{
        $requisiciondetalle->delete();
        return array(1,"exito");
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }
}
