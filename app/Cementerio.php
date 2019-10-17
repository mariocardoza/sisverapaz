<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cementerio extends Model
{
    public function positiones()
    {
        return $this->hasMany("App\CementeriosPosiciones");
    }
}
