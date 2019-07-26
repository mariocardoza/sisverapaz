<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\DatesTranslator;

class Solicitudcotizacion extends Model
{

  use DatesTranslator;
    protected $guarded =[];

    public $dates = ['fecha_limite'];

    public function cotizacion()
    {
        return $this->hasMany('App\Cotizacion');
    }

    public function cotizacion_seleccionada()
    {
        return $this->hasOne('App\Cotizacion')->where('seleccionado',1);
    }

    public function detalle()
    {
      return $this->hasMany('App\Solicitudcotizaciondetalle','solicitud_id');
    }

    public function formapago()
    {
    	return $this->belongsTo('App\Formapago');
    }

    public function presupuestosolicitud()
    {
        return $this->belongsTo('App\PresupuestoSolicitud','solicitud_id');
    }

    public function requisicion()
    {
      return $this->belongsTo('App\Requisicione');
    }

    public static function correlativo()
    {
      $numero=Solicitudcotizacion::where('created_at','>=',date('Y'.'-1-1'))->where('created_at','<=',date('Y'.'-12-31'))->count();
      if($numero>0 && $numero<10){
        return "00".($numero+1)."-".date("Y");
      }else{
        if($numero >= 10 && $numero <100){
          return "0".($numero+1)."-".date("Y");
        }else{
          if($numero>=100){
            return ($numero+1)."-".date("Y");
          }else{
            return "001-".date("Y");
          }
        }
      }
    }

    public static function modal_cotizacion($id){
      $modal='';
      $solicitud=Solicitudcotizacion::find($id);
      $proveedores=Proveedor::where('estado',1)->get();
      $formapagos=formapago::all();

      $modal.='<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_registrar_coti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Registrar cotizacion</h4>
          </div>
          <div class="modal-body">
                      <form class="form-horizontal" id="form_coti">
      
                  <div class="form-group">
                      <label for="" class="col-md-4 control-label">Proveedor</label>
                      <div class="col-md-6">
                          <select name="proveedor" id="proveedor" class="chosen-select-width">
                              <option value="">Seleccione un proveedor</option>';
                              foreach($proveedores as $proveedor):
                              $modal.='<option value="'.$proveedor->id.'">'.$proveedor->nombre.'</option>';
                              endforeach;
                          $modal.='</select>
                      </div>
               
                  </div>
      
                  <div class="form-group">
                      <label for="descripcion" class="col-md-4 control-label">Forma de pago</label>
      
                      <div class="col-md-6">
                          <input type="hidden" value="'.$solicitud->id.'" name="id" id="id_solicoti"/>
                        
                          <select name="descripcion" id="descripcion" class="chosen-select-width laformapago">
                              <option value="">Seleccione la forma de pago</option>';
                              foreach($formapagos as $forma):
                              $modal.='<option value="'.$forma->id.'">'.$forma->nombre.'</option>';
                              endforeach;
                          $modal.='</select>
                      </div>
                      
                  </div>
                  <div class="table-responsive">
                    <table class="table table-striped" id="tabla" display="block;">
                        <thead>
                            <tr>
                                <th width="50%">Descripción</th>
                                <th width="10%">Unidad de medida</th>
                                <th width="10%">Cantidad</th>
                                <th width="10%">Marca</th>
                                <th width="10%">Precio unitario</th>
                                <th width="10%">Total</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo">';
                          foreach($solicitud->detalle as $detalle):
                            $modal.='<tr>
                              <td>'.$detalle->material->nombre.'</td>
                              <td>'.$detalle->material->unidadmedida->nombre_medida.'</td>
                              <td>'.$detalle->cantidad.'
                                <input type="hidden" name="unidades[]" value="'.$detalle->material->unidadmedida->id.'"/>
                                <input type="hidden" name="descripciones[]" value="'.$detalle->material->nombre.'"/>
                                <input type="hidden" name="cantidades[]" value="'.$detalle->cantidad.'"/>
                              </td>
                              <td><input type="text" name="marcas[]" class="marcas form-control"/></td>
                              <td><input name="precios[]" data-cantidad="'.$detalle->cantidad.'" type="number" min="0.01" step="any" class="precios form-control"/></td>
                              <td class="subtotal">$0.00</td>
                            </tr>';
                          endforeach;
                        $modal.='</tbody>
                    </table>
                  </div>
      
                 
                  </form>
          </div>
          <div class="modal-footer">
            <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" id="registrar_lacoti" class="btn btn-success">Agregar</button></center>
          </div>
        </div>
        </div>
      </div>';

      return array(1,"exito",$modal);
    }
}
