<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany('App\FacturasItems');
    }
}