<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\DatesTranslator;
use DB;

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
      $numero=$numero+1;
      if($numero>0 && $numero<10){
        return "00".($numero)."-".date("Y");
      }else{
        if($numero >= 10 && $numero <100){
          return "0".($numero)."-".date("Y");
        }else{
          if($numero>=100){
            return ($numero)."-".date("Y");
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
        $hoy=Carbon::now();
        $limite= Carbon::createFromDate($solicitud->fecha_limite->format("Y"),$solicitud->fecha_limite->format("m"),$solicitud->fecha_limite->format("d"));
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
                    </br></br>
                    </br>
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-6">Fecha límite para recibir cotizaciones</div>
                        <div class="col-sm-6"><b>'.$limite->format('d/m/Y').'</b></div>
                      </div>
                    </div>
                    </fieldset>
                  </div>
                  <br>
                  <br>
                  <fieldset>
                  <legend>Cotizaciones';
                  if($solicitud->requisicion->conpresupuesto ==1):
                    if($solicitud->estado==1 && ($hoy <= $limite)):  
                    $html.='<button class="btn btn-primary btn-sm" type="button" id="registrar_cotizacion" data-id="'.$solicitud->id.'"><i class="fa fa-plus"></i></button>';
                    endif;
                  else:
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
                            $html.='<button id="seleccionar" title="Seleccionar esta cotización" type="button" data-id="'.$coti->id.'" data-requisicion="'.$solicitud->requisicion->id.'" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></button>';
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
        $hoy=Carbon::now();
        $limite= Carbon::createFromDate($solicitud->fecha_limite->format("Y"),$solicitud->fecha_limite->format("m"),$solicitud->fecha_limite->format("d"));
        
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
                    </br></br>
                    </br>
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-6">Fecha límite para recibir cotizaciones</div>
                        <div class="col-sm-6"><b>'.$solicitud->fecha_limite->format('d/m/Y').'</b></div>
                      </div>
                    </div>
                    </fieldset>
                  </div>
                  <br>
                  <br>
                  <fieldset>
                  <legend>Cotizaciones';
                  if($solicitud->estado==1 && ($hoy <= $limite)):  
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
                            $html.='<button id="seleccionar" title="Seleccionar esta cotización" type="button" data-id="'.$coti->id.'" data-proyecto="'.$solicitud->proyecto->id.'" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></button>';
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
                  if(isset($solicitud->cotizacion_seleccionada) && $solicitud->proyecto->estado>=6):
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
                      $html.='<label class="control-label">Registrar orden de compra</label><br>
                      <button type="button" id="registrar_orden" class="btn btn-primary" data-id="'.$solicitud->cotizacion_seleccionada->id.'">Registrar</button>';
                    endif; 
                  endif;
                      $html.'</div>
                    </div>';
                return array(1,"exito",$html);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public static function formulario_solicitud($id)
    {
      $formulario='';
      $formapagos=Formapago::where('estado',1)->get();
      $categorias=Categoria::where('estado',1)->get();
      $cates = DB::table('presupuestos as p')
        ->select(DB::raw('DISTINCT(c.id) as elid'),'c.nombre_categoria')
        ->join('presupuestodetalles as pd','p.id','=','pd.presupuesto_id','inner')
        ->join('materiales as m','m.id','=','pd.material_id','inner')
        ->join('categorias as c','c.id','=','m.categoria_id','inner')
        ->where('p.proyecto_id',$id)
        ->where('pd.estado',1)
        ->get();

      $proyecto=Proyecto::find($id);
      $formulario.='<div class="col-md-11">
        <div class="panel panel-primary">
          <div class="panel-heading">Registro de solicitudes</div>
          <div class="panel-body">
          <form class="form-horizontal" id="form_solicitudcotizacion">
            
          <div class="form-group">
          <label for="" class="col-md-4 control-label">Encargado\a del proceso: </label>
          <div class="col-md-6">
              <input type="text" class="form-control" name="encargado" readonly id="encargado" value="'.usuario(Auth()->user()->empleado_id).'">
          </div>
      </div>

      <div class="form-group">
          <label for="" class="col-md-4 control-label">Cargo: </label>
          <div class="col-md-6">
          <input type="text" class="form-control" name="cargo" readonly id="cargo" value="'.Auth()->user()->roleuser->role->description.'">
          </div>
      </div>

      <div class="form-group">
          <label for="" class="col-md-4 control-label">Proceso o proyecto: </label>
          <div class="col-md-6">
                <input type="hidden" name="proyecto" id="proyecto" value="'.$proyecto->id.'">
                <textarea readonly class="form-control">'.$proyecto->nombre.'</textarea>
          </div>
      </div>

  

      <div class="form-group">
          <label for="" class="col-md-4 control-label">Forma de pago: </label>
          <div class="col-md-6">
            <select name="formapago" id="formapago" class="chosen-select-width">
                <option value="">Seleccione una forma de pago...</option>';
                foreach ($formapagos as $forma):
                  $formulario.='<option value="'.$forma->id.'">'.$forma->nombre.'</option>';
                endforeach;   
            $formulario.='</select>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-primary" id="" data-toggle="modal" data-target="#modalformapago"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
      </div>

      <div class="form-group">
          <label for="lugar_entrega" class="col-md-4 control-label">Lugar de entrega de los suministros</label>

          <div class="col-md-6">
                <textarea name="lugar_entrega" class="form-control" id="lugar_entrega" rows="2"></textarea>
          </div>
      </div>

      <div class="form-group">
        <label for="fecha_limite" class="col-md-4 control-label">Fecha limite para cotizar</label>
        <div class="col-md-6">
            <input type="text" class="form-control unafecha" name="fecha_limite" id="fecha_limite">
        </div>
      </div>

      <div class="form-group">
        <label for="tiempo_entrega" class="col-md-4 control-label">Tiempo de entrega</label>
        <div class="col-md-6">
        <input type="text" class="form-control" name="tiempo_entrega" id="tiempo_entrega" autocomplete="off">   
        </div>
      </div>
      
      <div class="form-group">
          <label for="" class="control-label col-md-4">
              Seleccione la categoría
          </label>
          <div class="col-md-6">
              <select name="" id="filtrar_categoria" class="chosen-select-width"> 
                  <option value="0">Todos</option>';
                  foreach ($cates  as $item):
                      $formulario.='<option value="'.$item->elid.'">'.$item->nombre_categoria.'</option>';
                  endforeach;
              $formulario.='</select>
          </div>
      </div>

      <table class="table table-striped" id="tabla" display="block;">
          <thead>
              <tr>
                  <th width="5%"><input type="checkbox" checked id="todos">Todos</th>
                  
                  <th width="10%">N°</th>
                  <th width="50%">DESCRIPCIÓN</th>
                  <th width="10%"><center>UNIDAD DE MEDIDA</center></th>
                  <th width="10%"><center>CANTIDAD</center></th>
                  <th width="10%"><center>PRECIO UNITARIO</center></th>
                  <th width="5%">SUBTOTAL</th>
              </tr>
          </thead>
          <tbody id="cuerpo2">';
              foreach($proyecto->presupuesto->presupuestodetalle as $key => $detalle):
                  if($detalle->estado==1):
                  $formulario.='<tr>
                  <td><input type="checkbox" checked data-idcambiar="'.$detalle->id.'" data-material="'.$detalle->material_id.'" data-cantidad="'.$detalle->cantidad.'" class="lositemss"></td>
                      <td>'.($key+1).'</td>
                      <td>'.$detalle->material->nombre.'</td>
                      <td>'.$detalle->material->unidadmedida->nombre_medida.'</td>
                      <td>'.$detalle->cantidad.'</td>
                      <td></td>
                      <td></td>
                  </tr>';
                  endif;
                  endforeach;
          $formulario.='</tbody>
      </table>

            <div class="form-group">
              <center>
                <button type="button" id="registrar_soli" class="btn btn-success">
                  Registrar
                </button>
                <button id="cancelar_soli" class="btn btn-primary">Cancelar</button>
              </center>
            </div>
            </form>
          </div>
        </div>
      </div>';

    return array(1,"exito",$formulario);
    }

    public static function formulario_solicitudr($id)
    {
      $formulario="";
      $formapagos=Formapago::where('estado',1)->get();
      $requisicion=Requisicione::find($id);
      $formulario.='<div>
        <div class="panel panel-primary">
          <div class="panel-heading">Registro de solicitudes</div>
          <div class="panel-body">
          <form class="form-horizontal" id="form_solicitudcotizacion">
            
          <div class="form-group">
          <label for="" class="col-md-4 control-label">Encargado\a del proceso: </label>
          <div class="col-md-6">
              <input type="text" class="form-control" name="encargado" readonly id="encargado" value="'.Auth()->user()->empleado->nombre.'">
          </div>
      </div>

      <div class="form-group">
          <label for="" class="col-md-4 control-label">Cargo: </label>
          <div class="col-md-6">
          <input name="unidad" type="hidden" value="'.$requisicion->user->cargo.'">
          <input type="text" class="form-control" name="cargo" readonly id="cargo" value="'.Auth()->user()->roleuser->role->description.'">
          </div>
      </div>

      <div class="form-group">
          <label for="" class="col-md-4 control-label">Actividad: </label>
          <div class="col-md-6">
                <input type="hidden" name="requisicion" id="requisicion" value="'.$requisicion->id.'">
                <textarea readonly class="form-control">'.$requisicion->actividad.'</textarea>
          </div>
      </div>

  

      <div class="form-group">
          <label for="" class="col-md-4 control-label">Forma de pago: </label>
          <div class="col-md-6">
            <select name="formapago" id="formapago" class="chosen-select-width">
                <option value="">Seleccione una forma de pago...</option>';
                foreach ($formapagos as $forma):
                  $formulario.='<option value="'.$forma->id.'">'.$forma->nombre.'</option>';
                endforeach;   
            $formulario.='</select>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-primary" id="" data-toggle="modal" data-target="#modalformapago"><span class="glyphicon glyphicon-plus"></span></button>
        </div>
      </div>

      <div class="form-group">
          <label for="lugar_entrega" class="col-md-4 control-label">Lugar de entrega de los suministros</label>

          <div class="col-md-6">
                <textarea name="lugar_entrega" class="form-control" id="lugar_entrega" rows="2"></textarea>
          </div>
      </div>

      <div class="form-group">
        <label for="fecha_limite" class="col-md-4 control-label">Fecha limite para cotizar</label>
        <div class="col-md-6">
            <input type="text" class="form-control unafecha" name="fecha_limite" id="fecha_limite">
        </div>
      </div>

      <div class="form-group">
        <label for="tiempo_entrega" class="col-md-4 control-label">Tiempo de entrega</label>
        <div class="col-md-6">
        <input type="text" class="form-control" name="tiempo_entrega" id="tiempo_entrega" autocomplete="off">   
        </div>
      </div>

      <table class="table table-striped" id="tabla" display="block;">
          <thead>
              <tr>
                  <th width="5%"><input type="checkbox" checked id="todos">Todos</th>
                  <th width="5%">ÍTEM</th>
                  <th width="50%">DESCRIPCIÓN</th>
                  <th width="15%">UNIDAD DE MEDIDA</th>
                  <th width="10%">CANTIDAD</th>
                  <th width="10%">PRECIO UNITARIO</th>
                  <th width="10%">SUBTOTAL</th>
              </tr>
          </thead>
          <tbody >';
              foreach($requisicion->requisiciondetalle as $key => $detalle):
                  if($detalle->estado==1):
                  $formulario.='<tr>
                  <td><input type="checkbox" checked data-idcambiar="'.$detalle->id.'" data-material="'.$detalle->materiale_id.'" data-cantidad="'.$detalle->cantidad.'" class="lositemss"></td>
                      <td>'.($key+1).'</td>
                      <td>'.$detalle->material->nombre.'</td>
                      <td>'.$detalle->unidadmedida->nombre_medida.'</td>
                      <td>'.$detalle->cantidad.'</td>
                      <td></td>
                      <td></td>
                  </tr>';
                  endif;
                  endforeach;
          $formulario.='</tbody>
      </table>

            <div class="form-group">
              <center>
                <button type="button" id="agregar_soli" class="btn btn-success">
                  Registrar
                </button>
                <button id="cancelar_soli" class="btn btn-primary">Cancelar</button>
              </center>
            </div>
            </form>
          </div>
        </div>
      </div>';

    return array(1,"exito",$formulario);
    }
}
