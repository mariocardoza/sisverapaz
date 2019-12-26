<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiciosPago extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at','fecha_pago'];

    public function servicio()
    {
        return $this->belongsTo('App\Servicio');
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta');
    }
}
