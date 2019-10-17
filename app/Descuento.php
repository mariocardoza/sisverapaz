<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    public function categoriadescuento()
    {
        return $this->belongsTo('App\CategoriaDescuento');
    }
}
