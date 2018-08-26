<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $guarded = [];

    public static function Buscar($nombre,$estado)
    {
        return Cotizacion::nombre($nombre)->estado($estado)->orderBy('id')->paginate(10);
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

    public function detallecotizacion()
    {
        return $this->hasMany('App\Detallecotizacion');
    }

    public function solicitudcotizacion()
    {
        return $this->belongsTo('App\Solicitudcotizacion');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }

    public function ordencompra()
    {
        return $this->hasOne('App\Ordencompra');
    }
}
