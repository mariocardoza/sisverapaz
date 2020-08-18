<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class SolicitudRequisicion extends Model
{
    protected $guarded = [];
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $dates = ['fecha_acta'];

    public function requisiciones()
    {
        return $this->hasMany('App\Requisicione','solirequi_id');
    }

    public static function estado_ver($id)
  {
    $requisicion=SolicitudRequisicion::find($id);
    $html="";
    switch ($requisicion->estado) {
      case 1:
        $html.='<span class="col-xs-12 label-primary">En espera</span>';
        break;
      case 2:
        $html.='<span class="col-xs-12 label-danger">Rechazado</span>';
        break;
      case 3:
        $html.='<span class="col-xs-12 label-info">Aceptada y recibiendo cotizaciones</span>';
        break;
      case 4:
        $html.='<span class="col-xs-12 label-info">Pendiente de realizar orden de compra</span>';
        break;
      case 5:
        $html.='<span class="col-xs-12 label-warning"><strong>Pendiente de recibir insumos</strong></span>';
        break;
      case 6:
        $html.='<span class="col-xs-12 label-success"><strong>Insumos recibidos</strong></span>';
        break;
      case 7:
        $html.='<span class="col-xs-12 label-success"><strong>Proceso finalizado</strong></span>';
        break;
      case 9:
          $html.='<span class="col-xs-12 label-info"><strong>Combinada con otras req.</strong></span>';
          break;
      default:
        $html.='<span class="col-xs-12 label-success">Default</span>';
        break;
    }

    return $html;
  }

    public static function informacion($id)
    {
      $lasoli="";
      $html="";
      $tabla="";
      try{
        $requisicion=SolicitudRequisicion::find($id);
        $combinadas=DB::table('requisiciondetalles as rd')
        ->select('m.nombre','c.nombre_categoria as cnombre','m.codigo','rd.materiale_id as elid','m.categoria_id','um.nombre_medida',DB::raw('SUM(rd.cantidad) AS suma'))
        ->join('materiales as m','m.id','=','rd.materiale_id','inner')
        ->join('unidad_medidas as um','um.id','=','rd.unidad_medida','inner')
        ->join('requisiciones as r','r.id','=','rd.requisicion_id')
        ->join('categorias as c','c.id','=','m.categoria_id')
        ->where('r.estado','=',9)
        ->where('r.solirequi_id','=',$id)
        ->groupBy('m.id','rd.unidad_medida')
        ->get();
        $html.='<div class="text-center">';
        if(Auth()->user()->hasRole('uaci')):
          if($requisicion->estado==1):
            $html.='<a title="Aprobar requisicion" href="javascript:void(0)" id="modal_aprobar" class="btn btn-primary" ><i class="fa fa-check"></i></a>';
          elseif($requisicion->estado==5):
            $html.='<a title="Materiales recibidos" href="javascript:void(0)" class="btn btn-primary" id="materiales_recibidos"><i class="glyphicon glyphicon-check"></i></a>';
          elseif($requisicion->estado==6):
            $html.='<a title="Finalizar" href="javascript:void(0)" class="btn btn-primary" id="terminar_proceso"><i class="glyphicon glyphicon-check"></i></a>';
          elseif($requisicion->estado==7):
            $html.='<a title="Descargar" href="requisiciones/bajar/'.$requisicion->nombre_archivo.'" class="btn btn-primary" id=""><i class="glyphicon glyphicon-download"></i></a>';
          else:
          endif;
        endif;
        $html.='<span>Este es un consolidado de las siguientes requisiciones:</span>  
                <ul>';
                    foreach ($requisicion->requisiciones as $r):
                        $html.='<li><a href="../reportesuaci/requisicionobra/'.$r->id.'" target="_blank">'.$r->codigo_requisicion.'</a></li>'; 
                    endforeach;
                    
                $html.='</ul>';
        $html.='</div>

        <br>
        <div class="col-sm-12">
          <span><center>'.SolicitudRequisicion::estado_ver($requisicion->id).'</center></span>
        </div>';
        if(isset($requisicion->cuenta_id)):
        $html.='<div class="clearfix"></div>
        <hr style="margin-top: 3px; margin-bottom: 3px;">
        <div class="col-sm-12">
          <span style="font-weight: normal;">Fuente de financiamiento:</span>
        </div>
        <div class="col-sm-12">
          <span><b>'.$requisicion->cuenta->nombre.'</b></span>
        </div>';
        else:
          $html.='<div class="clearfix"></div>
        <hr style="margin-top: 3px; margin-bottom: 3px;">
        <div class="col-sm-12">
          <span style="font-weight: normal;">Fuente de financiamiento:</span>
        </div>
        <div class="col-sm-12">
          <span><b>Sin definir</b></span>
        </div>';
        endif;  
        
            $lasoli.='<div>';
            if($requisicion->solicitudcotizacion->count() > 0): 
                $lasoli.='<center>
                  <button class="btn btn-primary pull-right" data-id="'.$requisicion->id.'" id="registrar_solicitud">Registrar</button>
                </center>';
                $lasoli.='<div class="row">
                <div class="col-xs-2">
                  <div class="col-sm-12">
                    <span>&nbsp</span>
                  </div>';
                  foreach($requisicion->solicitudcotizacion as $soli):
                  $lasoli.='<button data-id="'.$soli->id.'" id="lasolicitud" class="btn btn-primary col-sm-12">'.$soli->numero_solicitud.'</button>';
                    $lasoli.='<div class="clearfix"></div>
                    <hr style="margin-top: 3px; margin-bottom: 3px;">';
                  endforeach;
                $lasoli.='</div>
                <div class="col-xs-9" id="aquilasoli">
                  <h1 class="text-center">Seleccione una solicitud para mostrar la información</h1>
                </div>
              </div>';
            else: 
              if($requisicion->estado==1):
                $lasoli.='<center>
                    <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                    <span>La requisición no ha sido aprobada</span><br>
                  </center>';
              elseif($requisicion->estado==2):
                $lasoli.='<center>
                    <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                    <span>La requisición fue rechazada</span><br>
                  </center>';
              else:
                $lasoli.='<center>
                    <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                    <span>Registre la solicitud</span><br>
                    <button class="btn btn-primary" data-id="'.$requisicion->id.'" id="registrar_solicitud">Registrar</button>
                  </center>';
              endif;
            endif;
            $lasoli.='</div>';

            $tabla.='<table class="table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>U/M</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($combinadas as $i=>$c):
                $tabla.='<tr>
                    <td>'.($i+1).'</td>
                    <td>'.$c->codigo.'</td>
                    <td>'.$c->nombre.'</td>
                    <td>'.$c->suma.'</td>
                    <td>'.$c->nombre_medida.'</td>
                    <td>'.$c->cnombre.'</td>
                </tr>';
          endforeach;
          $tabla.='</tbody>
          </table>';
        return array(1,$html,$tabla,$lasoli);
      }catch(Exception $e){
  
      }
    }public static function formulario_solicitud($id)
    {
      $formulario='';
      $solicitud=SolicitudRequisicion::find($id);
      $formapagos=Formapago::where('estado',1)->get();
      $combinadas=DB::table('requisiciondetalles as rd')
        ->select('m.nombre','c.nombre_categoria as cnombre','m.codigo','rd.materiale_id as elid','m.categoria_id','um.nombre_medida','um.id as uni_id',DB::raw('SUM(rd.cantidad) AS suma'))
        ->join('materiales as m','m.id','=','rd.materiale_id','inner')
        ->join('unidad_medidas as um','um.id','=','rd.unidad_medida','inner')
        ->join('requisiciones as r','r.id','=','rd.requisicion_id')
        ->join('categorias as c','c.id','=','m.categoria_id')
        ->where('r.estado','=',9)
        ->where('r.solirequi_id','=',$id)
        ->groupBy('m.id','rd.unidad_medida')
        ->get();

      $proyecto=Proyecto::find($id);
      $formulario.='<div class="col-md-12">
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
          <label for="" class="col-md-4 control-label">Proceso: </label>
          <div class="col-md-6">
                <input type="hidden" name="solicitud" id="solicitud" value="'.$solicitud->id.'">
                <textarea readonly class="form-control"></textarea>
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
                  
                  <th width="10%">N°</th>
                  <th width="50%">DESCRIPCIÓN</th>
                  <th width="10%"><center>UNIDAD DE MEDIDA</center></th>
                  <th width="10%"><center>CANTIDAD</center></th>
                  <th width="10%"><center>PRECIO UNITARIO</center></th>
                  <th width="5%">SUBTOTAL</th>
              </tr>
          </thead>
          <tbody id="cuerpo2">';
              foreach($combinadas as $key => $detalle):
                  $formulario.='<tr>
                  <td><input type="checkbox" checked data-unidad="'.$detalle->uni_id.'" data-material="'.$detalle->elid.'" data-cantidad="'.$detalle->suma.'" class="lositemss"></td>
                      <td>'.($key+1).'</td>
                      <td>'.$detalle->nombre.'</td>
                      <td>'.$detalle->nombre_medida.'</td>
                      <td>'.$detalle->suma.'</td>
                      <td></td>
                      <td></td>
                  </tr>';
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



    public function solicitudcotizacion()
    {
        return $this->hasMany('App\Solicitudcotizacion','solirequi_id');
    }

    public function cuenta()
  {
    return $this->belongsTo('App\Cuenta');
  }
}
