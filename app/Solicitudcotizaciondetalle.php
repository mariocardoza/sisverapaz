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
}
