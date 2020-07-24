<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratacionDirecta extends Model
{
    protected $guarded = [];

    public function emergencia()
    {
        return $this->belongsTo('App\Emergencia','emergencia_id')->withDefault();
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor')->withDefault();
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo('App\User')->withDefault();
    }

    public function detalle()
    {
        return $this->hasMany('App\ContratacionDetalle','contratacion_id');
    }

    public function materiales()
    {
        return $this->hasMany('App\CompraDirecta','contratacion_id');
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
