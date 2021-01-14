<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaNegocio extends Model
{
    protected $guarded = [];
    protected $dates=['fechaVecimiento'];
    
    public function inmueble()
    {
        return $this->belongsTo('App\Inmueble','inmueble_id');
    }

    public function items()
    {
        return $this->hasMany('App\FacturaNegocioItem');
    }
}
