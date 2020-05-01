<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $guarded = [];
    protected $dates=['fechaVecimiento'];

    public function items()
    {
        return $this->hasMany('App\FacturasItems');
    }

    public function inmueble()
    {
        return $this->belongsTo('App\Inmueble','mueble_id');
    }
}