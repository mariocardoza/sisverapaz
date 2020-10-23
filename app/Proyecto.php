<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\DatesTranslator;



class Proyecto extends Model
{
  use DatesTranslator;
    protected $guarded = [];
    protected $dates = ['fecha_inicio','fecha_fin','fecha_acta'];

    public static function Buscar($nombre,$estado)
    {
        return Proyecto::nombre($nombre)->estado($estado)->orderBy('id')->paginate(10);
    }

    public function scopeEstado($query,$estado)
    {
        return $query->where('estado',$estado);
    }
    public function scopeNombre($query,$nombre)
    {
    	if(trim($nombre != "")){
            return $query->where('nombre','iLIKE', '%'.$nombre.'%');
    	}

    }

    public static function modal_editar($id)
    {
      
    }

    public static function informacion($id)
    {
      $informacion="";
      try{
        $proyecto=Proyecto::find($id);
        $informacion.='<div class="col-sm-12 hidden-print"><center>';
        if($proyecto->tiene_solicitudes->count() == 0 && $proyecto->estado==7 && $proyecto->indicadores_completado->sum('porcentaje') < 100 && $proyecto->tipo_proyecto ==1) :
        $informacion.='
          <button class="btn btn-primary btn-sm" id="materiales_recibidos" title="Materiales recibidos"><i class="fa fa-check"></i></button>
        </br><br>';
        elseif($proyecto->estado==8 && $proyecto->indicadores_completado->sum('porcentaje') < 100 && $proyecto->tipo_proyecto ==1):
          $informacion.='
          <button class="btn btn-primary btn-sm" id="modal_pausar" title="Pausar el proyecto"><i class="fa fa-pause"></i></button>
        </br><br>';
        elseif($proyecto->estado==9 && $proyecto->indicadores_completado->sum('porcentaje') < 100 && $proyecto->tipo_proyecto ==1):
          $informacion.='
          <button class="btn btn-primary btn-sm" id="reanudar_proyecto" title="Reanudar el proyecto"><i class="fa fa-play"></i></button>
        </br><br>';
        elseif($proyecto->indicadores_completado->sum('porcentaje') == 100 && $proyecto->estado < 12 && $proyecto->tipo_proyecto ==1):
          $informacion.='<button class="btn btn-primary btn-sm" id="finalizar_proyecto" title="Finalizar el proyecto"><i class="fa fa-check"></i></button>
          </br><br>';
        elseif($proyecto->tipo_proyecto ==2 && ($proyecto->estado==6 || $proyecto->estado==8)):
          $informacion.='<button class="btn btn-primary btn-sm cambiar_licitacion" data-id="'.$proyecto->id.'" data-estado="7"  title="Iniciar el proyecto"><i class="fa fa-play"></i></button>
          </br><br>';
        elseif($proyecto->tipo_proyecto ==2 && $proyecto->estado==7 && $proyecto->indicadores_completado->sum('porcentaje') < 100):
          $informacion.='<button class="btn btn-primary btn-sm cambiar_licitacion" data-id="'.$proyecto->id.'" data-estado="8"  title="pausar el proyecto"><i class="fa fa-pause"></i></button>
          </br><br>';
        elseif($proyecto->tipo_proyecto ==2 && $proyecto->estado==9):
          $informacion.='<button class="btn btn-primary btn-sm cambiar_licitacion" data-id="'.$proyecto->id.'" data-estado="7"  title="Reactivar el proyecto"><i class="fa fa-forward"></i></button>
          </br><br>';
        elseif($proyecto->tipo_proyecto ==2 && ($proyecto->estado==11 || $proyecto->estado==12) && isset($proyecto->proyectoacta->archivo)):
          $informacion.='<a href="../proyectos/bajaracta/'.$proyecto->proyectoacta->archivo.'" class="btn btn-primary btn-sm" data-id="'.$proyecto->id.'" title="Descargar acta del proyecto"><i class="fa fa-download"></i></a>
          </br><br>';
         elseif($proyecto->tipo_proyecto ==1 && ($proyecto->estado==12 || $proyecto->estado==13) && isset($proyecto->proyectoacta->archivo)):
            $informacion.='<a href="../proyectos/bajaracta/'.$proyecto->proyectoacta->archivo.'" class="btn btn-primary btn-sm" data-id="'.$proyecto->id.'" title="Descargar acta del proyecto"><i class="fa fa-download"></i></a>
            </br><br>';
        endif;
        if($proyecto->tipo_proyecto==2 && $proyecto->estado==8):
          $informacion.='<button class="btn btn-primary btn-sm cambiar_licitacion" data-id="'.$proyecto->id.'" data-estado="9"  title="Inactivar el proyecto"><i class="fa fa-stop"></i></button>
          </br><br>';
        endif;
        if($proyecto->indicadores_completado->sum('porcentaje') == 100 && $proyecto->estado ==7 && $proyecto->tipo_proyecto ==2):
          $informacion.='<button class="btn btn-primary btn-sm" id="finalizar_proyecto" title="Finalizar el proyecto"><i class="fa fa-check"></i></button>
          </br><br>';
        endif;
        $informacion.='</center></div>
        <div class="col-sm-12">
        <span class="col-xs-12 label label-'.estilo_proyecto($proyecto->estado,$proyecto->id).'">'.proyecto_estado($proyecto->estado,$proyecto->id).'</span>
        </div>
        <div class="clearfix"></div>
        <hr style="margin-top: 3px; margin-bottom: 3px;">';
        if($proyecto->estado==9):
          $informacion.='<div class="col-sm-12">
          <span>Motivo de pausa:</span>
        </div>
        <div class="col-sm-12">
          <span><b>'.$proyecto->motivo_pausa.'</b></span>
        </div>
        <div class="clearfix"></div>
        <hr style="margin-top: 3px; margin-bottom: 3px; background-color:red;">';
        endif;
        $informacion.='<div class="col-sm-12 hidden-print">
        <span>Nombre del proyecto:</span>
      </div>
      <div class="col-sm-12">
        <span><b>'.$proyecto->nombre.'</b></span>
      </div>
      <div class="clearfix"></div>
      <hr style="margin-top: 3px; margin-bottom: 3px;">
      <div class="col-sm-12">
        <span>Justificación:</span>
      </div>
      <div class="col-sm-12">
        <span><b>'.$proyecto->motivo.'</b></span>
      </div>
      <div class="clearfix"></div>
      <hr style="margin-top: 3px; margin-bottom: 3px;">
      <div class="col-sm-12">
        <span>Dirección donde se ejecutará:</span>
      </div>
      <div class="col-sm-12">
        <span><b>'.$proyecto->direccion.'</b></span>
      </div>
      <div class="clearfix"></div>
      <hr style="margin-top: 3px; margin-bottom: 3px;">
      <div class="col-sm-12">
        <span>Avance del proyecto:</span>
      </div>
      <div class="col-sm-12 progress progress-striped active">
        <div class="progress-bar progress-bar-success" role="progressbar"
            aria-valuenow="'.$proyecto->indicadores_completado->sum('porcentaje').'" aria-valuemin="0" aria-valuemax="100"
          style="width: '.$proyecto->indicadores_completado->sum('porcentaje').'%">
          <span class="">'.$proyecto->indicadores_completado->sum('porcentaje').'% completado</span>
        </div>
      </div>
      <div class="clearfix"></div>
      <hr style="margin-top: 3px; margin-bottom: 3px;">
      <div class="col-sm-12">
        <span>Origen de los fondos:</span>
      </div>';
      foreach ($proyecto->fondo as $fondo):
          $informacion.='<div class="col-sm-7">
            <span><b>&nbsp;&nbsp;'.$fondo->cuenta->nombre.'</b></span>
          </div>
          <div class="col-sm-5">
            <span class="label label-primary col-sm-12">
              $'.number_format($fondo->monto,2).'
            </span>
          </div>';
      endforeach;
      $informacion.='<div class="col-sm-7">
        <span><b>&nbsp;&nbsp;Total</b></span>
      </div>
      <div class="col-sm-5">
        <span class="label label-success col-sm-12">
          $'.number_format($proyecto->monto,2).'
        </span>
      </div>
      <div class="clearfix"></div>
      <hr style="margin-top: 3px; margin-bottom: 3px;">
      <div class="col-sm-12">
        <span>Fecha de inicio:</span>
      </div>
      <div class="col-sm-12">
        <span><b>'.$proyecto->fecha_inicio->format('l d').' de '.$proyecto->fecha_inicio->format('F Y').'</b></span>
      </div>
      <div class="clearfix"></div>
      <hr style="margin-top: 3px; margin-bottom: 3px;">
      <div class="col-sm-12">
        <span>Fecha de finalización:</span>
      </div>
      <div class="col-sm-12">
        <span><b>'.$proyecto->fecha_fin->format('l d').' de '.$proyecto->fecha_fin->format('F Y').'</b></span>
      </div>
      <div class="clearfix"></div>
      <hr style="margin-top: 3px; margin-bottom: 3px;">
      <div class="col-sm-7">
        <span>Monto de Desarrollo</span>
      </div>
      <div class="col-sm-5">
        <span class="label label-primary col-sm-12">
          $'.number_format($proyecto->monto_desarrollo,2).'
        </span>
      </div>
      <div class="clearfix"></div>
      <hr style="margin-top: 3px; margin-bottom: 3px;">
      <div class="col-sm-7">
        <span>Beneficiarios</span>
      </div>
      <div class="col-sm-5">
        <span class="label label-primary col-sm-12">
          '.$proyecto->beneficiarios.'
        </span>
      </div>';


        return array(1,"exito",$informacion);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public static function solicitudes($id)
    {
      $lasoli="";
      $proyecto=Proyecto::find($id);
      $lasoli.='<div>';
          if($proyecto->solicitudcotizacion->count() > 0): 
              if(Proyecto::tiene_materiales($proyecto->presupuesto->id)):
              $lasoli.='<center>
                <button class="btn btn-primary pull-right" data-id="'.$proyecto->id.'" id="registrar_solicitud">Registrar</button>
              </center>';
              endif; 
              $lasoli.='<div class="row">
              <div class="col-xs-2">
                <div class="col-sm-12">
                  <span>&nbsp</span>
                </div>';
                foreach($proyecto->solicitudcotizacion as $soli):
                $lasoli.='<button data-id="'.$soli->id.'" id="lasolicitud" class="btn btn-primary col-sm-12">'.$soli->numero_solicitud.'</button>';
                  $lasoli.='<div class="clearfix"></div>
                  <hr style="margin-top: 3px; margin-bottom: 3px;">';
                endforeach;
              $lasoli.='</div>
              <div class="col-xs-9" id="aquilasoli">
                <h2 class="text-center">Seleccione una solicitud para mostrar la información</h2>
              </div>
            </div>';
          else: 
            if($proyecto->estado==1):
              $lasoli.='<center>
                  <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                  <span>El proyecto no tiene presupuesto aprobado</span><br>
                </center>';
            elseif($proyecto->estado==11):
              $lasoli.='<center>
                  <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                  <span>La requisición fue rechazada</span><br>
                </center>';
            else:
              $lasoli.='<center>
                  <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                  <span>Registre la solicitud</span><br>
                  <button class="btn btn-primary" data-id="'.$proyecto->id.'" id="registrar_solicitud">Registrar</button>
                </center>';
            endif;
          endif;
          $lasoli.='</div>';
          return array(1,"exito",$lasoli);
    }

    public static function elpresupuesto($id){
      $presu="";
      try{
        $proyecto=Proyecto::find($id);
        $presu.='	<h4><i class="glyphicon glyphicon-briefcase"></i></h4>
		
        <table class="table table-striped table-hover" id="example2">
          <thead>
            <th>Descripción</th>
            <th>Unidad de medida</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>';
            if($proyecto->estado==1):
            $presu.='<th>Opciones</th>';
            endif;
             $contador=0; $total=0.0;
          $presu.='</thead>
          <tbody>';
            
              $categ=array();
            if(isset($proyecto->presupuesto->presupuestodetalle)):
            foreach($proyecto->presupuesto->presupuestodetalle as $detalle):
            
              if(!in_array($detalle->material->categoria->nombre_categoria,$categ)){
                $categ[]=$detalle->material->categoria->nombre_categoria;
              }
              
            
            endforeach;
          endif;
          foreach($categ as $c):
            $presu.='<tr><th colspan="6" class="text-center">'.$c.'</th></tr>';
            foreach($proyecto->presupuesto->presupuestodetalle as $detalle):
            if($c==$detalle->material->categoria->nombre_categoria):
           
              $presu.='<tr>';
                $contador++;
                  $total=$total+$detalle->cantidad*$detalle->preciou;
                $presu.='<td>'.$detalle->material->nombre.'</td>
                <td>'.$detalle->unidadmedida->nombre_medida.'</td>
                <td>'.$detalle->cantidad.'</td>
                <td class="text-right">$'.number_format($detalle->preciou,2).'</td>
                <td class="text-right">$'.number_format($detalle->cantidad*$detalle->preciou,2).'</td>
                <td>';
                  if($proyecto->estado==1):
                  $presu.='<div class="btn-group">
                    <a class="btn btn-warning btn-xs" href="javascript:void(0)"><span class="glyphicon glyphicon-edit"></span></a>
                    <button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                    </div>';
                  endif;
                $presu.='</td>
              </tr>';
            endif;
          endforeach;
        endforeach;
              $presu.='<tr>';
              if($proyecto->estado==1):
                $presu.='<td colspan="5" class="text-center">TOTAL</td>';
              else:
                $presu.='<td colspan="4" class="text-center">TOTAL</td>';
              endif;
                $presu.='<td class="text-right" colspan="2"><b>$'.number_format($total,2).'</b></td>
              </tr>
          </tbody>
        </table>';

        return array(1,"exito",$presu);
      }catch(Exception $e){

      }
    }

    public static function codigo_proyecto($monto)
    {
      $configurarion=Configuracion::first();
      if($monto>$configurarion->licitacion){
        $numero=Proyecto::where('created_at','>=',date('Y'.'-1-1'))->where('created_at','<=',date('Y'.'-12-31'))->where('monto','>',$configurarion->licitacion)->count();
        $numero=$numero++;
        if($numero>0 && $numero<10){
          return "LP-00".($numero)."-".date("Y");
        }else{
          if($numero >= 10 && $numero <100){
            return "LP-0".($numero)."-".date("Y");
          }else{
            if($numero>=100){
              return "LP-".($numero)."-".date("Y");
            }else{
              return "LP-001-".date("Y");
            }
          }
        }
      }else{
        $numero=Proyecto::where('created_at','>=',date('Y'.'-1-1'))->where('created_at','<=',date('Y'.'-12-31'))->where('monto','<=',$configurarion->licitacion)->count();
        $numero=$numero++;
        if($numero>0 && $numero<10){
          return "LG-00".($numero)."-".date("Y");
        }else{
          if($numero >= 10 && $numero <100){
            return "LG-0".($numero)."-".date("Y");
          }else{
            if($numero>=100){
              return "LG-".($numero)."-".date("Y");
            }else{
              return "LG-001-".date("Y");
            }
          }
        }
      }
    }

    public static function tipo_proyecto($monto)
    {
      $configurarion=Configuracion::first();
      if($monto>$configurarion->licitacion){
        return 2;
      }else{
        return 1;
      }
    }

    public static function portipo($tipo)
    {
      switch($tipo){
        case 2:
        $proyectos=Proyecto::where('estado',11)->whereYear('created_at',date('Y'))->orderBy('created_at','DESC')->get();
        break;
        case 9:
        $proyectos=Proyecto::where('estado',13)->whereYear('created_at',date('Y'))->orderBy('created_at','DESC')->get();
        break;
        default:
        $proyectos=Proyecto::where('estado','<>',12)->where('estado','<>',13)->whereYear('created_at',date('Y'))->orderBy('created_at','DESC')->get();
      }
  
      $html="";
  
        $html.='<table class="table table-striped table-bordered" id="latabla">
        <thead>
          <th width="1%">N°</th>
          <th width="15%">Código</th>
          <th width="20%">Nombre Proyecto</th>
          <th width="4%">Monto</th>
          <th width="25%">Dirección</th>
          <th width="10%">Inicio</th>
          <th width="10%">Fin</th>
          <th width="5%">Estado</th>
          <th width="10%">Acción</th>
        </thead>
        <tbody>';
    
        foreach($proyectos as $key => $proyecto):
          $html.='<tr>
          <td>'. ($key+1).'</td>
          <td>'. $proyecto->codigo_proyecto .'</td>
          <td>'. $proyecto->nombre .'</td>
          <td>$'. number_format($proyecto->monto,2) .'</td>
          <td>'. $proyecto->direccion .'</td>
          <td>'. $proyecto->fecha_inicio->format('d-m-Y') .'</td>
          <td>'. $proyecto->fecha_fin->format('d-m-Y') .'</td>
          <td>
            <span class="col-xs-12 label label-'.estilo_proyecto($proyecto->estado,$proyecto->id).'">'.proyecto_estado($proyecto->estado,$proyecto->id).'</span>
          </td>
          <td><a href="proyectos/'.$proyecto->id.'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span></a></td>
          </tr>';
        endforeach;
        $html.='</tbody></table>';
    
        return array(1,$html);
    }

    public static function poranio($anio)
  {
    $html="";

    try{
      $proyectos=Proyecto::whereYear('created_at',$anio)->orderBy('created_at','DESC')->get();

      $html.='<table class="table table-striped table-bordered" id="latabla">
      <thead>
        <th width="1%">N°</th>
        <th width="15%">Código</th>
        <th width="20%">Nombre Proyecto</th>
        <th width="4%">Monto</th>
        <th width="25%">Dirección</th>
        <th width="10%">Inicio</th>
        <th width="10%">Fin</th>
        <th width="5%">Estado</th>
        <th width="10%">Acción</th>
      </thead>
      <tbody>';
  
      foreach($proyectos as $key => $proyecto):
        $html.='<tr>
        <td>'. ($key+1).'</td>
        <td>'. $proyecto->codigo_proyecto.'</td>
        <td>'. $proyecto->nombre .'</td>
        <td>$'. number_format($proyecto->monto,2) .'</td>
        <td>'. $proyecto->direccion .'</td>
        <td>'. $proyecto->fecha_inicio->format('d-m-Y') .'</td>
        <td>'. $proyecto->fecha_fin->format('d-m-Y') .'</td>
        <td>
          <span class="col-xs-12 label label-'.estilo_proyecto($proyecto->estado,$proyecto->id).'">'.proyecto_estado($proyecto->estado,$proyecto->id).'</span>
        </td>
        <td><a href="proyectos/'.$proyecto->id.'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span></a></td>
        </tr>';
      endforeach;
      $html.='</tbody></table>';

    return array(1,$html);
    }catch(Exception $e){
      $html.='<table class="table table-striped table-bordered" id="latabla">
    <thead>
      <th width="3%">N°</th>
      <th width="5%">Código</th>
      <th width="20%">Nombre Proyecto</th>
      <th width="5%">Monto</th>
      <th width="25%">Dirección</th>
      <th width="10%">Inicio</th>
      <th width="10%">Fin</th>
      <th width="5%">Estado</th>
      <th width="15%">Acción</th>
    </thead>
    <tbody></tbody></table>';
    return array(-1,$html);
    }
  
  }

    public static function tiene_materiales($id){
      $retorno=false;
      $detas=Presupuestodetalle::where('presupuesto_id',$id)->get();
      foreach($detas as $deta){
        if($deta['estado']==1){
          $retorno=true;
        }
      }
      return $retorno;
    }

    public static function empleados($id)
    {
      try{
        $html="";
        $proyecto=Proyecto::find($id);
        $html.='<button class="btn btn-primary" id="nuevo_empleado">Registrar empleado <i class="fa fa-save"></i></button> | ';
        if($proyecto->periodoactivo->count()==1):
          $html.='<a href="../reportesuaci/asistenciaproyecto/'.$proyecto->id.'" target="_blank" class="btn btn-success vista_previa" title="Imprimir asistencia">Imprimir asistencia <i class="fa fa-print"></i></a>';
        endif;
        
        $html.='<table class="table" id="latabla2">
        <thead>
          <tr>
            <th>N°</th>
            <th>Empleado</th>
            <th>Cargo</th>
            <th></th>
          </tr>
        </thead>
        <tbody>';
          foreach ($proyecto->detalleplanilla as $index => $item):
            $html.='<tr>
              <td>'.($index+1).'</td>
              <td>'.$item->empleado->nombre.'</td>
              <td>'.$item->cargoproyecto->nombre.'</td>
              <td> <button class="btn btn-danger btn-sm" id="quitar_empleado" type="button" data-proyecto="'.$proyecto->id.'" data-id="'.$item->id.'"><i class="fa fa-remove"></i></button> </td>
            </tr>';
          endforeach;
        $html.='</tbody>
      </table>';
      return array(1,"exito",$html);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public static function pagos($id)
    {
      try{
        $proyecto=Proyecto::find($id);
        $html="";
        $html.='<button class="btn btn-primary" id="nueva_jornada">Nueva catorcena <i class="fa fa-save"></i></button>
        <table class="table" id="latabla">
        <thead>
          <tr>
            <th>N°</th>
            <th>Jornada</th>
            <th>Fecha de inicio</th>
            <th>Fecha fin</th>
            <th>Estado</th>
            <th></th>
          </tr>
        </thead>
        <tbody>';
          foreach ($proyecto->periodoproyecto as $index => $item):
            $html.='<tr>
              <td>'.($index+1).'</td>
              <td>Catorcena</td>
              <td>'.$item->fecha_inicio->format("d/m/Y").'</td>
              <td>'.$item->fecha_fin->format("d/m/Y").'</td>
              <td>'.PeriodoProyecto::estado($item->id).'</td>
              <td>';
              if($item->estado==1):
              $html.='<button id="elpago" class="btn btn-primary btn-sm" type="button" data-id="'.$item->id.'"><i class="fa fa-eye"></i></button>
                      <a href="../reportesuaci/proyectoempleados/'.$item->id.'" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-print"></i></a>';
              elseif($item->estado==2):
                $html.='<button class="btn btn-primary btn-sm" id="pagarplanilla" data-id="'.$item->id.'" type="button"><i class="fa fa-money"></i></button>
                <a class="btn btn-success btn-sm" href="../reportesuaci/planillaproyecto/'.$item->id.'" target="_blank" data-id="'.$item->id.'" type="button"><i class="fa fa-print"></i></a>';
              elseif($item->estado==3):
                $html.='<a class="btn btn-success btn-sm" href="../reportesuaci/planillaproyecto/'.$item->id.'" target="_blank" data-id="'.$item->id.'" type="button"><i class="fa fa-print"></i></a>';
              endif;
              $html.=' </td>
              </tr>';
          endforeach;
        $html.='</tbody>
      </table>';
      return array(1,"exito",$html);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public static function generar_planilla($idproy,$id)
    {
      $html="";
      try{
        $proyecto=Proyecto::find($idproy);
        $catorcena=PeriodoProyecto::find($id);
        $html.='<h3>Pago del:'.$catorcena->fecha_inicio->format("d/m/Y").' al '.$catorcena->fecha_fin->format("d/m/Y").'</h3>
        <form id="form_planilla">
        <table class="table" id="laplanilla">
        <thead>
          <tr>
            <th>N°</th>
            <th>Empleado</th>
            <th>Cargo</th>
            <th>Días trabajados</th>
            <th>Total neto</th>
            <th>Renta</th>
            <th>Líquido</th>
          </tr>
        </thead>
        <tbody>';
        foreach($proyecto->detalleplanilla as $index => $d):
          $renta=$subto=0.0;
          $renta=($d->cargoproyecto->salario_dia * 14)*session('renta');
          $subto=($d->cargoproyecto->salario_dia*14)-$renta;
          $html.='<tr data-empleado="'.$d->empleado->id.'">
            <td>'.($index+1).'</td>
            <td>'.$d->empleado->nombre.'</td>
            <td>'.$d->cargoproyecto->nombre.'</td>
            <td>
            <input type="number" data-saldia="'.$d->cargoproyecto->salario_dia.'" name="dias[]" class="form-control losdias" value="14">
            <input type="hidden" name="empleados[]" value="'.$d->empleado->id.'">
            <input type="hidden" name="salario_dia[]" value="'.$d->cargoproyecto->salario_dia.'">
            <input type="hidden" name="cargo[]" value="'.$d->cargoproyecto_id.'">
            </td>
            <td>$'.number_format(($d->cargoproyecto->salario_dia * 14),2).'</td>
            <td>$'.number_format($renta,2).'</td>
            <td>$'.number_format($subto,2).'</td>
          </tr>';
        endforeach;
        $html.='</tbody>
        </table>
        </form>
        <center>
          <button class="btn btn-danger" id="cancelar_planilla">Cancelar</button>
          <button type="button" class="btn btn-primary" data-proyecto="'.$proyecto->id.'" data-catorcena="'.$catorcena->id.'" id="guardar_plani">Guardar</button>
        </center>
        ';
        return array(1,"exito",$html);
      }catch(Excpetion $e){
        return array(-1,"error",$e->getMessage());
      }    

    }

    public function tiene_solicitudes()
    {
      return $this->hasMany('App\Solicitudcotizacion')->where('estado',3);
    }

    public function contratoproyectos()
    {
      return $this->hasMany('App\ContratoProyecto');
    }

    public function presupuestoinventario()
    {
      return $this->hasMany('App\PresupuestoInventario');
    }

    public function licitacion()
    {
      return $this->hasMany('App\Licitacion')->orderBy('estado','asc')->orderBy('created_at','ASC');
    }

    public function licitacionbase()
    {
      return $this->hasMany('App\LicitacionBase')->orderBy('estado','asc')->orderBy('created_at','ASC');
    }

    public function indicadores()
    {
      return $this->hasMany('App\IndicadoresProyecto','proyectos_id');
    }

    public function indicadores_completado()
    {
      return $this->hasMany('App\IndicadoresProyecto','proyectos_id')->where('estado',2);
    }

    public function solicitudcotizacion()
    {
      return $this->hasMany('App\Solicitudcotizacion','proyecto_id');
    }

    public function presupuesto()
    {
      return $this->hasOne('App\Presupuesto');
    }

    public function fondo()
    {
        return $this->hasMany('App\Fondo');
    }

    public function cuentaproy()
    {
        return $this->hasOne('App\Cuentaproy');
    }

    public function organizacion()
    {
        return $this->belongsTo('App\Organizacion');
    }

    public function cuenta()
    {
      return $this->hasOne('App\Cuentaproy');
    }

    public function bitacoraproyecto()
    {
      return $this->hasMany('App\BitacoraProyecto');
    }

    public function detalleplanilla()
    {
      return $this->hasMany('App\Detalleplanilla');
    }

    public function datoplanilla()
    {
      return $this->hasMany('App\Datoplanilla');
    }

    public function periodoproyecto()
    {
      return $this->hasMany('App\PeriodoProyecto')->orderby('created_at','DESC');
    }

    public function periodoactivo()
    {
      return $this->hasMany('App\PeriodoProyecto')->where('estado',1);
    }

    public function calendario()
    {
      return $this->hasMany('App\Calendarizacion')->orderby('inicio','asc');
    }

    public function proyectoacta()
    {
      return $this->hasOne('App\ProyectoActa');
    }
}
