<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class FacturasItems extends Model
{
    protected $guarded = [];
    public $table = "factura_items";

    public function tiposervicio()
    {
        return $this->belongsToMany('App\Inmueble');
    }

    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }
}