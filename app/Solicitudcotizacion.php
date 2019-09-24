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

    public function proyecto()
    {
      return $this->belongsTo('App\Proyecto','proyecto_id');
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
                                <input type="hidden" name="descripciones[]" value="'.$detalle->material->id.'"/>
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

    public static function lasolicitud($id)
    {
      $html='';
      try{
        $solicitud=Solicitudcotizacion::find($id);
        $html.='<div class="panel">
                  <div class="row">
                  <fieldset>
                  <legend>Solicitud de cotización</legend>
                    <div class="col-sm-3">
                    <span style="font-weight: normal;">Solicitud N°:</span>
                    </div>
                    <div class="col-sm-3">
                      <span><b>'. $solicitud->numero_solicitud.'</b></span>
                    </div>
                    <div class="col-sm-2">
                    <span style="font-weight: normal;">Encargado:</span>
                    </div>
                    <div class="col-sm-2">
                      <span><b>'. $solicitud->encargado.'</b></span>
                    </div>
                    <div class="col-sm-2">
                      <a class="btn btn-primary btn-sm" target="_blank" href="../reportesuaci/solicitud/'.$solicitud->id.'"><i class="fa fa-print"></i></a>
                    </div>
                    </fieldset>
                  </div>
                  <br>
                  <br>
                  <fieldset>
                  <legend>Cotizaciones';
                  if($solicitud->estado==1):  
                  $html.='<button class="btn btn-primary btn-sm" type="button" id="registrar_cotizacion" data-id="'.$solicitud->id.'"><i class="fa fa-plus"></i></button>';
                  endif;
                  $html.='</legend>
                  <div id="">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Ítem</th>
                          <th>Cantidad</th>';
                          foreach($solicitud->cotizacion as $coti):
                            $html.='<th>';
                            if($coti->seleccionado==1):
                            $html.='<span title="Click para ver información" style="cursor:pointer; color:green" id="ver_coti" data-id="'.$coti->id.'">'.$coti->proveedor->nombre.'</span> <br>';
                            else:
                              $html.='<span title="Click para ver información" style="cursor:pointer;" id="ver_coti" data-id="'.$coti->id.'">'.$coti->proveedor->nombre.'</span> <br>';
                            endif;
                            if($solicitud->estado==1):
                            $html.='<button id="seleccionar" type="button" data-id="'.$coti->id.'" data-requisicion="'.$solicitud->requisicion->id.'" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></button>';
                            endif;
                            $html.='</th>';
                          endforeach;
                        $html.='</tr>
                      </thead>
                      <tbody>';
                        foreach ($solicitud->detalle as $detalle):
                            $html.='<tr>
                            <td>'.$detalle->material->nombre.'</td>
                            <td>'.$detalle->cantidad.'</td>';
                            foreach($solicitud->cotizacion as $lacoti):
                              foreach($lacoti->detallecotizacion as $key => $eldeta):
                                if(($eldeta->material_id==$detalle->material_id) ):
                                  if($lacoti->seleccionado==1):
                                  $html.='<td style="color:green">$'.number_format($detalle->cantidad*$eldeta->precio_unitario,2).'</td>';
                                  else:
                                  $html.='<td>$'.number_format($detalle->cantidad*$eldeta->precio_unitario,2).'</td>';
                                  endif;
                                endif;
                              endforeach;
                            endforeach;
                            $html.='</tr>';
                        endforeach;
                      $html.='</tbody>
                      <tfoot>
                        <tr>
                          <th colspan="2">Total</th>';
                          foreach($solicitud->cotizacion as $coti):
                            if($coti->seleccionado==1):
                              $html.='<th style="color:green;">$'.number_format(Cotizacion::total_cotizacion($coti->id),2).'</th>';
                            else:
                              $html.='<th>$'.number_format(Cotizacion::total_cotizacion($coti->id),2).'</th>';
                            endif;
                          endforeach;
                        $html.='</tr>
                        <tr>
                          <th colspan="2">Forma de pago</th>';
                          foreach($solicitud->cotizacion as $coti):
                            if($coti->seleccionado==1):
                            $html.='<th style="color:green;">'.$coti->formapago->nombre.'</th>';
                            else:
                            $html.='<th>'.$coti->formapago->nombre.'</th>';
                            endif;
                          endforeach;
                        $html.='</tr>
                      </tfoot>
                    </table>
                      </fieldset>
                    </div>
                  <br><br>';
                  if(isset($solicitud->cotizacion_seleccionada)):
                    if(isset($solicitud->cotizacion_seleccionada->ordencompra)):
                    $html.='<div>
                    <fieldset>
                    <legend>Orden de compra</legend>
                    <div class="row">
                      <div class="col-md-2">
                      <span style="font-weight: normal;">Orden N°:</span>
                      </div>
                      <div class="col-md-2">
                      <span><b>'.$solicitud->cotizacion_seleccionada->ordencompra->numero_orden.'</b></span>
                      </div>
                      <div class="col-md-3">
                      <span style="font-weight: normal;">Fuente de financiamiento:</span>
                      </div>
                      <div class="col-md-3">
                      <span><b>'.$solicitud->requisicion->cuenta->nombre.'</b></span>
                      </div>
                      <!--div class="col-md-3">
                      <span style="font-weight: normal;">Entrega de bienes:</span>
                      </div>
                      <div class="col-md-3">
                      <span><b>Desde el'.$solicitud->cotizacion_seleccionada->ordencompra->fecha_inicio->format('l d').' de '.$solicitud->cotizacion_seleccionada->ordencompra->fecha_inicio->format('F').'</b></span>
                      </div-->
                      <div class="col-sm-2">
                        <a class="btn btn-primary btn-sm" target="_blank" href="../reportesuaci/ordencompra/'.$solicitud->cotizacion_seleccionada->ordencompra->id.'"><i class="fa fa-print"></i></a>
                      </div>
                    </div>
                    </fieldset>
                    <br><br>';
                    if($solicitud->requisicion->estado>=6):
                    $html.='<fieldset>
                    <legend>Acta de recepcion de bienes</legend>
                    <a title="Imprimir acta" href="../reportesuaci/acta/'.$solicitud->cotizacion_seleccionada->ordencompra->id.'" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                    </fieldset>';
                    endif;
                    $html.='</div>';
                    else:
                      $html.='<button type="button" id="registrar_orden" class="btn btn-primary" data-id="'.$solicitud->cotizacion_seleccionada->id.'">Registrar</button>';
                    endif; 
                  endif;
                      $html.'</div>
                    </div>';
                return array(1,"exito",$html);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public static function lasolicitud_proyecto($id)
    {
      $html='';
      try{
        $solicitud=Solicitudcotizacion::find($id);
        $html.='<div class="panel">
                  <div class="row">
                  <fieldset>
                  <legend>Solicitud de cotización</legend>
                    <div class="col-sm-3">
                    <span style="font-weight: normal;">Solicitud N°:</span>
                    </div>
                    <div class="col-sm-3">
                      <span><b>'. $solicitud->numero_solicitud.'</b></span>
                    </div>
                    <div class="col-sm-2">
                    <span style="font-weight: normal;">Encargado:</span>
                    </div>
                    <div class="col-sm-2">
                      <span><b>'. $solicitud->encargado.'</b></span>
                    </div>
                    <div class="col-sm-2">
                      <a class="btn btn-primary btn-sm" target="_blank" href="../reportesuaci/solicitud/'.$solicitud->id.'"><i class="fa fa-print"></i></a>
                    </div>
                    </fieldset>
                  </div>
                  <br>
                  <br>
                  <fieldset>
                  <legend>Cotizaciones';
                  if($solicitud->estado==1):  
                  $html.='<button class="btn btn-primary btn-sm" type="button" id="registrar_cotizacion" data-id="'.$solicitud->id.'"><i class="fa fa-plus"></i></button>';
                  endif;
                  $html.='</legend>
                  <div id="">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Ítem</th>
                          <th>Cantidad</th>';
                          foreach($solicitud->cotizacion as $coti):
                            $html.='<th>';
                            if($coti->seleccionado==1):
                            $html.='<span title="Click para ver información" style="cursor:pointer; color:green" id="ver_coti" data-id="'.$coti->id.'">'.$coti->proveedor->nombre.'</span> <br>';
                            else:
                              $html.='<span title="Click para ver información" style="cursor:pointer;" id="ver_coti" data-id="'.$coti->id.'">'.$coti->proveedor->nombre.'</span> <br>';
                            endif;
                            if($solicitud->estado==1):
                            $html.='<button id="seleccionar" type="button" data-id="'.$coti->id.'" data-proyecto="'.$solicitud->proyecto->id.'" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></button>';
                            endif;
                            $html.='</th>';
                          endforeach;
                        $html.='</tr>
                      </thead>
                      <tbody>';
                        foreach ($solicitud->detalle as $detalle):
                            $html.='<tr>
                            <td>'.$detalle->material->nombre.'</td>
                            <td>'.$detalle->cantidad.'</td>';
                            foreach($solicitud->cotizacion as $lacoti):
                              foreach($lacoti->detallecotizacion as $key => $eldeta):
                                if(($eldeta->material_id==$detalle->material_id) ):
                                  if($lacoti->seleccionado==1):
                                  $html.='<td style="color:green">$'.number_format($detalle->cantidad*$eldeta->precio_unitario,2).'</td>';
                                  else:
                                  $html.='<td>$'.number_format($detalle->cantidad*$eldeta->precio_unitario,2).'</td>';
                                  endif;
                                endif;
                              endforeach;
                            endforeach;
                            $html.='</tr>';
                        endforeach;
                      $html.='</tbody>
                      <tfoot>
                        <tr>
                          <th colspan="2">Total</th>';
                          foreach($solicitud->cotizacion as $coti):
                            if($coti->seleccionado==1):
                              $html.='<th style="color:green;">$'.number_format(Cotizacion::total_cotizacion($coti->id),2).'</th>';
                            else:
                              $html.='<th>$'.number_format(Cotizacion::total_cotizacion($coti->id),2).'</th>';
                            endif;
                          endforeach;
                        $html.='</tr>
                        <tr>
                          <th colspan="2">Forma de pago</th>';
                          foreach($solicitud->cotizacion as $coti):
                            if($coti->seleccionado==1):
                            $html.='<th style="color:green;">'.$coti->formapago->nombre.'</th>';
                            else:
                            $html.='<th>'.$coti->formapago->nombre.'</th>';
                            endif;
                          endforeach;
                        $html.='</tr>
                      </tfoot>
                    </table>
                      </fieldset>
                    </div>
                  <br><br>';
                  if(isset($solicitud->cotizacion_seleccionada)):
                    if(isset($solicitud->cotizacion_seleccionada->ordencompra)):
                    $html.='<div>
                    <fieldset>
                    <legend>Orden de compra</legend>
                    <div class="row">
                      <div class="col-md-2">
                      <span style="font-weight: normal;">Orden N°:</span>
                      </div>
                      <div class="col-md-2">
                      <span><b>'.$solicitud->cotizacion_seleccionada->ordencompra->numero_orden.'</b></span>
                      </div>
                      <div class="col-md-3">
                      <span style="font-weight: normal;">Fuente de financiamiento:</span>
                      </div>
                      <div class="col-md-3">
                      <span><b></b></span>
                      </div>
                      <!--div class="col-md-3">
                      <span style="font-weight: normal;">Entrega de bienes:</span>
                      </div>
                      <div class="col-md-3">
                      <span><b>Desde el'.$solicitud->cotizacion_seleccionada->ordencompra->fecha_inicio->format('l d').' de '.$solicitud->cotizacion_seleccionada->ordencompra->fecha_inicio->format('F').'</b></span>
                      </div-->
                      <div class="col-sm-2">
                        <a class="btn btn-primary btn-sm" target="_blank" href="../reportesuaci/ordencompra/'.$solicitud->cotizacion_seleccionada->ordencompra->id.'"><i class="fa fa-print"></i></a>
                      </div>
                    </div>
                    </fieldset>
                    <br><br>';
                    if($solicitud->proyecto->estado>=8):
                    $html.='<fieldset>
                    <legend>Acta de recepcion de bienes</legend>
                    <a title="Imprimir acta" href="../reportesuaci/acta/'.$solicitud->cotizacion_seleccionada->ordencompra->id.'" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                    </fieldset>';
                    endif;
                    $html.='</div>';
                    else:
                      $html.='<button type="button" id="registrar_orden" class="btn btn-primary" data-id="'.$solicitud->cotizacion_seleccionada->id.'">Registrar</button>';
                    endif; 
                  endif;
                      $html.'</div>
                    </div>';
                return array(1,"exito",$html);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }
}
