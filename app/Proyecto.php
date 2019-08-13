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

    public function presupuestoinventario()
    {
      return $this->hasMany('App\PresupuestoInventario');
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
