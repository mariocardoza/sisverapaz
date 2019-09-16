<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\DatesTranslator;



class Proyecto extends Model
{
  use DatesTranslator;
    protected $guarded = [];
    protected $dates = ['fecha_inicio','fecha_fin'];

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
            <span><b>&nbsp;&nbsp;'.$fondo->fondocat->categoria.'</b></span>
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

    public static function codigo_proyecto($monto)
    {
      $configurarion=Configuracion::first();
      if($monto>$configurarion->licitacion){
        $numero=Proyecto::where('created_at','>=',date('Y'.'-1-1'))->where('created_at','<=',date('Y'.'-12-31'))->where('monto','>',$configurarion->licitacion)->count();
        if($numero>0 && $numero<10){
          return "LP-00".($numero+1)."-".date("Y");
        }else{
          if($numero >= 10 && $numero <100){
            return "LP-0".($numero+1)."-".date("Y");
          }else{
            if($numero>=100){
              return "LP-".($numero+1)."-".date("Y");
            }else{
              return "LP-001-".date("Y");
            }
          }
        }
      }else{
        $numero=Proyecto::where('created_at','>=',date('Y'.'-1-1'))->where('created_at','<=',date('Y'.'-12-31'))->where('monto','<=',$configurarion->licitacion)->count();
        if($numero>0 && $numero<10){
          return "LG-00".($numero+1)."-".date("Y");
        }else{
          if($numero >= 10 && $numero <100){
            return "LG-0".($numero+1)."-".date("Y");
          }else{
            if($numero>=100){
              return "LG-".($numero+1)."-".date("Y");
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

    public function presupuesto()
    {
      return $this->hasMany('App\Presupuesto');
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
      return $this->hasOne('App\Cuenta');
    }

    public function bitacoraproyecto()
    {
      return $this->hasMany('App\BitacoraProyecto');
    }
}
