<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitudcotizaciondetalle extends Model
{
    protected $guarded =[];

    public function material()
    {
        return $this->belongsTo('App\Materiales');
    }

    public function unidadmedida()
    {
      return $this->belongsTo('App\UnidadMedida','unidad_medida')->withDefault();
    }
}
