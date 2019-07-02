<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisicione extends Model
{
  protected $fillable = ['id','codigo_requisicion','actividad','user_id','observaciones','fondocat_id','unidad_id'];
  protected $primaryKey = "id";
  public $incrementing = false;

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

  public static function estado_ver($id){
    $requisicion=Requisicione::find($id);
    $html="";
    switch ($requisicion->estado) {
      case 1:
        $html.='<span class="label-primary">En espera</span>';
        break;
      case 2:
        $html.='<span class="label-danger">Rechazado</span>';
        break;
      case 3:
        $html.='<span class="label-info">Aceptada y recibiendo cotizaciones</span>';
        break;
      case 4:
        $html.='<span class="label-warning">Pendiente de realizar orden de compra</span>';
        break;
      case 5:
        $html.='<span class="label-success"><strong>Pendiente de recibir insumos</strong></span>';
        break;
      case 5:
        $html.='<span class="label-success"Proceso Finalizado</span>';
        break;
      default:
        $html.='<span class="label-success">Default</span>';
        break;
    }

    return $html;
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

  public function fondocat()
  {
    return $this->belongsTo('App\Fondocat');
  }
}
