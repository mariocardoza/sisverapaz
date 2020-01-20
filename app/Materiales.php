<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materiales extends Model
{
	protected $table="materiales";
    public $incrementing = false;
    protected $guarded=[];

    public function unidadmedida(){
    	return $this->belongsTo('App\UnidadMedida','unidad_id');
    }

    public function categoria(){
    	return $this->belongsTo('App\Categoria');
    }

    public static function modal_editar($id)
    {
        $modal="";
        try{
            $material=Materiales::find($id);
            $categorias=Categoria::where('estado',1)->get();
            $medidas=unidadmedida::get();
            $modal.='<div class="modal fade" tabindex="-1" id="md_material_edit" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="gridSystemModalLabel">Editar material</h4>
                </div>
                <div class="modal-body">
                  <form id="form_ematerial" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-4">Nombre</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nombre" value="'.$material->nombre.'">
                                </div>       
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-4">Categoría</label>
                                <div class="col-md-6">
                                    <select class="chosen-select-width" name="categoria_id">';
                                    foreach($categorias as $categoria):
                                        if($categoria->id==$material->categoria_id):
                                            $modal.='<option selected value="'.$categoria->id.'">'.$categoria->nombre_categoria.'</opcion>';
                                        else:
                                            $modal.='<option value="'.$categoria->id.'">'.$categoria->nombre_categoria.'</opcion>';
                                        endif;
                                    endforeach;
                                $modal.='</select></div>       
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-4">Unidad de medida</label>
                                <div class="col-md-6">
                                <select class="chosen-select-width" name="unidad_id">';
                                foreach($medidas as $medida):
                                    if($medida->id==$material->unidad_id):
                                        $modal.='<option selected value="'.$medida->id.'">'.$medida->nombre_medida.'</opcion>';
                                    else:
                                        $modal.='<option value="'.$medida->id.'">'.$medida->nombre_medida.'</opcion>';
                                    endif;
                                endforeach;
                                $modal.='</select>
                                </div>       
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-md-4">¿Es un servicio?</label>
                                <div class="col-md-6">
                                    <select class="chosen-select-width" name="servicio">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="button" id="editar_material" data-id="'.$material->id.'" class="btn btn-primary">Editar</button></center>
                </div>
              </div>
            </div>
          </div>';

            return array(1,"exito",$modal);
        }catch(Exception $e){

        }
    }
}
