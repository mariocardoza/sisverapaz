<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraDirecta extends Model
{
    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo('App\Materiales','material_id')->withDefault();
    }

    public function medida()
    {
        return $this->belongsTo('App\UnidadMedida','unidadmedida_id')->withDefault();
    }

    public function contratacion()
    {
        return $this->belongsTo('App\ContratacionDirecta','contratacion_id')->withDefault();
    }
}
