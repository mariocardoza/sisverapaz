<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $guarded=[];
    protected $dates=['fecha'];

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta');
    }
}
