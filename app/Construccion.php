<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;

class Construccion extends Model
{
    use DatesTranslator;
    protected $guarded = [];
    protected $dates=['fecha_pago'];

    public function contribuyente()
    {
    	return $this->belongsTo('App\Contribuyente');
    }

    public function inmueble()
    {
    	return $this->belongsTo('App\Inmueble');
    }

    public static function modal_edit($id)
    {
        $con=Construccion::find($id);
        $contri=Contribuyente::find($con->contribuyente_id);
        $modal="";
        $modal.='<div class="modal fade" tabindex="-1" id="modal_econstruccion" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="gridSystemModalLabel">Editar la construcción</h4>
            </div>
            <div class="modal-body">
                <form id="form_econstruccion" class="">
                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                        <label for="" class="control-label">Contribuyente</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input class="form-control" name="contribuyente_id" readonly value="'.$con->contribuyente->nombre.'">
                            </div>
                        
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="control-label">Inmueble</label>
                        <div class="row">
                            <div class="col-md-12">
                                <select name="inmueble_id" id="elinmueble_edit" class="chosen-select-width">
                                    <option value="">Seleccione el inmueble</option>';
                                    foreach($contri->inmueble as $i):
                                        if($con->inmueble_id==$i->id):
                                            $modal.='<option selected value="'.$i->id.'">'.$i->numero_catastral.'</option>';
                                        else:
                                            $modal.='<option  value="'.$i->id.'">'.$i->numero_catastral.'</option>';
                                        endif;
                                    endforeach;
                                $modal.='</select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="presupuesto" class="control-label">Presupuesto </label>
                    
                        <div class="">
                            <input class="form-control" name="presupuesto" type="number" value="'.$con->presupuesto.'" min="0" step="any">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="detalle" class="control-label">Detalle de la construccion (opcional) </label>
                    
                        <div class="">
                        <textarea class="form-control" name="detalle" rows="2">'.$con->detalle.'</textarea>

                        </div>
                    </div>
                    
                        </div>
                  </div>
                
            </div>
            <div class="modal-footer">
              <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="button" data-id="'.$con->id.'" class="btn btn-success eledit">Editar</button></center>
            </div>
          </form>
          </div>
        </div>
      </div>';
        return array(1,"exito",$modal);
    }
}
