<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoraNegocio extends Model
{
    public function inmueble()
    {
        return $this->belongsTo('App\Factura','inmueble_id');
    }
}
