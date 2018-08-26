<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisicione extends Model
{
  protected $fillable = ['codigo_requisicion','actividad','user_id','observaciones'];

  public static function correlativo()
  {
    $numero=Requisicione::where('created_at','>=',date('Y'.'-1-1'))->where('created_at','<=',date('Y'.'-12-31'))->count();
    if($numero>0 && $numero<10){
      return "RQ-00".($numero+1)."-".date("Y");
    }else{
      if($numero >= 10 && $numero <100){
        return "RQ-0".($numero+1)."-".date("Y");
      }else{
        if($numero>=100){
          return "RQ-".($numero+1)."-".date("Y");
        }else{
          return "RQ-001-".date("Y");
        }
      }
    }
  }

  public function unidad()
  {
    return $this->belongsTo('App\Unidad');
  }

  public function requisiciondetalle()
  {
    return $this->hasMany('App\Requisiciondetalle','requisicion_id');
  }

  public function solicitudcotizacion()
  {
    return $this->hasOne('App\Solicitudcotizacion','requisicion_id');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
