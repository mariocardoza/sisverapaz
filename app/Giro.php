<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giro extends Model
{
    protected $guarded = [];

    public function proveedor()
    {
        return $this->hasMany('App\Proveedor');
    }
}
