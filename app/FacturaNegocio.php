<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaNegocio extends Model
{
    protected $guarded = [];
    protected $dates=['fechaVecimiento'];
    
    public function negocio()
    {
        return $this->belongsTo('App\Negocio','negocio_id');
    }

    public function items()
    {
        return $this->hasMany('App\FacturaNegocioItem','facturanegocio_id');
    }
}
