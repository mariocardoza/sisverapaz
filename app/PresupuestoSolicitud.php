<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresupuestoSolicitud extends Model
{
    protected $guarded = [];

    public function solicitudcotizacion()
    {
      return $this->hasOne('App\Solicitudcotizacion','solicitud_id');
    }

    public function presupuesto()
    {
      return $this->belongsTo('App\Presupuesto');
    }
}
