<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;

class Ordencompra extends Model
{
  use DatesTranslator;
    protected $guarded = [];
    protected $dates = ['fecha_inicio', 'fecha_fin'];

    public function cotizacion()
    {
    	return $this->belongsTo('App\Cotizacion');
    }

    public static function correlativo()
    {
      $numero=Ordencompra::where('created_at','>=',date('Y'.'-1-1'))->where('created_at','<=',date('Y'.'-12-31'))->count();
      if($numero>0 && $numero<10){
        return intval("00".($numero+1).date('Y'));
      }else{
        if($numero >=10 && $numero < 100){
          return intval("0".($numero+1).date('Y'));
        }else{
          if($numero<=100){
            return intval(($numero+1).date('Y'));
          }else {
            return intval("1".date("Y"));
          }
        }
      }
    }

    public static function modal_registrar($id)
    {
      $modal='';
      $cotizacion=Cotizacion::find($id);
      $modal.='<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_registrar_orden" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Registrar la orden de compra</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="laordencompra">
                
            <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Nombre de la actividad</label>
        
            <div class="col-md-6">
              <input type="hidden" name="cotizacion_id" value="'.$cotizacion->id.'" id="cotizacion_id">
                <textarea name="actividad" rows="3" class="form-control" readonly>'.$cotizacion->solicitudcotizacion->requisicion->actividad.'
                </textarea>
            </div>
        </div>
        
        <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Nombre del proveedor</label>
        
            <div class="col-md-6">
            <input type="text" name="" value="'.$cotizacion->proveedor->nombre.'" class="form-control" readonly>
            </div>
        </div>
        
        
        <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Condiciones de pago</label>
        
            <div class="col-md-6">
            <input type="text" name="" value="'.$cotizacion->formapago->nombre.'" class="form-control" readonly>

            </div>
        </div>
        
        <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Nombre del administrador de la orden</label>
            <div class="col-md-6">
            <input type="text" name="adminorden" value="'.$cotizacion->solicitudcotizacion->requisicion->user->empleado->nombre.'" class="form-control" readonly>

            </div>
        </div>
        
        <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Dirección de entrega</label>
        
            <div class="col-md-6">
              <textarea name="direccion_entrega" rows="3" class="form-control" id="direccion_entrega"></textarea>
            </div>
        </div>
        
        <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Periodo de entrega</label>
        
            <div class="col-md-2">
              <input name="fecha_inicio" class="form-control" id="fecha_inicio" placeholder="Fecha de inicio" autocomplete="off">
            </div>
            <div class="col-md-1"><label for="">al</label></div>
            <div class="col-md-2">
              <input name="fecha_fin" class="form-control" id="fecha_fin" placeholder="Fecha final" autocomplete="off">

            </div>
        </div>
        
        <div class="form-group">
            <label for="nombre" class="col-md-4 control-label">Observaciones</label>
        
            <div class="col-md-6">
            <textarea name="observaciones" rows="2" class="form-control" id="observaciones"></textarea>

            </div>
        </div>
        
        <div class="box-body table-responsive">
            <table class="table table-striped table-bordered table-hover" id="">
                <thead>
                    <tr>
                        <th width="5%">N°</th>
                        <th width="40%">Descripcion</th>
                        <th width="10%">Marca</th>
                        <th width="10%">Unidad de medida</th>
                        <th width="10%">Cantidad</th>
                        <th width="10%">Precio Unitario</th>
                        <th width="15%">Subtotal</th>
                    </tr>';
                    $total=0.0; 
                $modal.='</thead>
                <tbody id="cuerpo">';
                  foreach($cotizacion->detallecotizacion as $key => $detalle):
                     $total=$total+$detalle->precio_unitario*$detalle->cantidad;
                    $modal.='<tr>
                      <td>'.($key+1).'</td>
                      <td>'.$detalle->descripcion.'</td>
                      <td>'.$detalle->marca.'</td>
                      <td>'.$detalle->unidadmedida->nombre_medida.'</td>
                      <td>'.$detalle->cantidad.'</td>
                      <td>$'.number_format($detalle->precio_unitario,2).'</td>
                      <td>$'.number_format($detalle->precio_unitario*$detalle->cantidad,2).'</td>
                    </tr>';
                  endforeach;
                $modal.='</tbody>
                <tfoot id="pie">
                    <tr>
                      <th colspan="6">Total en letras: '.numaletras($total).' </th>
                      <th>$'.number_format($total,2).'</th>
                    </tr>
                </tfoot>
            </table>
        </div>
      
            </form>
          </div>
          <div class="modal-footer">
            <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" id="agregar_orden" class="btn btn-success">Agregar</button></center>
          </div>
        </div>
        </div>
      </div>';

      return array(1,"exito",$modal);
    }
}
