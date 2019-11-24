<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cementerio extends Model
{
    public function posiciones()
    {
        return $this->hasMany("App\CementeriosPosiciones");
    }
}
