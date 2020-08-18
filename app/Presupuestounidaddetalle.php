<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuestounidaddetalle extends Model
{
	protected $guarded =[];
    public $timestamps = false;

    public function material()
    {
        return $this->belongsTo('App\Materiales');
    }

    public function unidadmedida()
    {
      return $this->belongsTo('App\UnidadMedida','unidad_medida')->withDefault();
    }

    public function materialunidad()
    {
      return $this->hasMany('App\MaterialUnidad','presupuestounidad_id');
    }

    public function disponibles()
    {
      return $this->hasMany('App\MaterialUnidad','presupuestounidad_id')->where('estado',1);
    }

    public function utilizados()
    {
      return $this->hasMany('App\MaterialUnidad','presupuestounidad_id')->where('estado',2);
    }

    public static function modal_editar($id){
        try{
            $detalle=Presupuestounidaddetalle::find($id);
            $modal="";
            $modal.='<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_editar_material" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="nom_material">Editar: <strong>'.$detalle->material->nombre.'</strong></h4>
                </div>
                <div class="modal-body">
                  <form id="form_edit_material">
                      
                    <div class="form-group">
                        <label for="" class="control-label">Cantidad</label>
                        <div class="">
                            <input type="number" autocomplete="off" min="1" steps="any" required name="cantidad" value="'.$detalle->cantidad.'" class="form-control">
                          <input type="hidden" id="elpresuid_edit" name="" value="'.$detalle->id.'" class="form-control">
        
                    </div>
                    </div>
        
                    <div class="form-group">
                        <label for="" class="control-label">Precio unitario</label>
                        <div>
                        <input type="number" min="1" steps="any" autocomplete="off" required name="precio" value="'.$detalle->precio.'" class="form-control">
                        </div>
                    </div>
                              
                  </form>
                </div>
                <div class="modal-footer">
                  <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="button" id="editar_presupuesto" class="btn btn-success">Editar</button></center>
                </div>
              </div>
              </div>
        </div>';
        return array(1,"exito",$modal,$detalle);
        }catch(Exception $e){

        }
    }
}
