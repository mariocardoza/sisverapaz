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
}
