<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoraInmueble extends Model
{
    public function inmueble()
    {
        return $this->belongsTo('App\Factura','inmueble_id');
    }
}
