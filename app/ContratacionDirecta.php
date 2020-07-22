<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratacionDirecta extends Model
{
    protected $guarded = [];

    public function emergencia()
    {
        return $this->belongsTo('App\Emergencia','emergencia_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function detalle()
    {
        return $this->hasMany('App\ContratacionDetalle','contratacion_id');
    }

    public static function codigo_proyecto()
    {
      
    $numero=ContratacionDirecta::where('created_at','>=',date('Y'.'-1-1'))->where('created_at','<=',date('Y'.'-12-31'))->count();
    $numero=$numero++;
    if($numero>0 && $numero<10){
        return "CD-00".($numero)."-".date("Y");
    }else{
        if($numero >= 10 && $numero <100){
        return "CD-0".($numero)."-".date("Y");
        }else{
        if($numero>=100){
            return "CD-".($numero)."-".date("Y");
        }else{
            return "CD-001-".date("Y");
        }
        }
    }
    }
}
