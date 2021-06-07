<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cementerio extends Model
{
    protected $dates = ['fecha_baja'];

    public function posiciones()
    {
        return $this->hasMany("App\CementeriosPosiciones");
    }
}
