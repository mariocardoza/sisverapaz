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

    public static function informacion($id)
    {
      $informacion="";
      try{
        $proyecto=Proyecto::find($id);
        if($proyecto->tiene_solicitudes->count() == 0 && $proyecto->estado==7):
        $informacion.='<div class="col-sm-12">
          <center><button class="btn btn-primary btn-sm" id="materiales_recibidos" title="Materiales recibidos"><i class="fa fa-check"></i></button></center>
        </div></br><br>';
        elseif($proyecto->estado==8):
          $informacion.='<div class="col-sm-12">
          <center><button class="btn btn-primary btn-sm" id="modal_pausar" title="Pausar el proyecto"><i class="fa fa-pause"></i></button></center>
        </div></br><br>';
        elseif($proyecto->estado==9):
          $informacion.='<div class="col-sm-12">
          <center><button class="btn btn-primary btn-sm" id="reanudar_proyecto" title="Reanudar el proyecto"><i class="fa fa-play"></i></button></center>
        </div></br><br>';
        endif;
        $informacion.='<div class="col-sm-12">
        <span class="col-xs-12 label label-'.estilo_proyecto($proyecto->estado).'">'.proyecto_estado($proyecto->estado).'</span>
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
        $informacion.='<div class="col-sm-12">
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
                <button class="btn btn-primary pull-right" id="registrar_solicitud">Registrar</button>
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
                  <button class="btn btn-primary" id="registrar_solicitud">Registrar</button>
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
            
            foreach($proyecto->presupuesto->presupuestodetalle as $detalle):
            
              if(!in_array($detalle->material->categoria->nombre_categoria,$categ)){
                $categ[]=$detalle->material->categoria->nombre_categoria;
              }
              
            
            endforeach;
          foreach($categ as $c):
            $presu.='<tr><th colspan="6" class="text-center">'.$c.'</th></tr>';
            foreach($proyecto->presupuesto->presupuestodetalle as $detalle):
            if($c==$detalle->material->categoria->nombre_categoria):
           
              $presu.='<tr>';
                $contador++;
                  $total=$total+$detalle->cantidad*$detalle->preciou;
                $presu.='<td>'.$detalle->material->nombre.'</td>
                <td>'.$detalle->material->unidadmedida->nombre_medida.'</td>
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
        $proyectos=Proyecto::where('estado',9)->whereYear('created_at',date('Y'))->orderBy('created_at','DESC')->get();
        break;
        default:
        $proyectos=Proyecto::where('estado','<>',11)->where('estado','<>',9)->whereYear('created_at',date('Y'))->orderBy('created_at','DESC')->get();
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
          <span class="col-xs-12 label label-'.estilo_proyecto($proyecto->estado).'">'.proyecto_estado($proyecto->estado).'</span>
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
          <span class="col-xs-12 label label-'.estilo_proyecto($proyecto->estado).'">'.proyecto_estado($proyecto->estado).'</span>
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

    public function indicadores()
    {
      return $this->hasMany('App\IndicadoresProyecto');
    }

    public function indicadores_completado()
    {
      return $this->hasMany('App\IndicadoresProyecto')->where('estado',2);
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
}
