<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CementeriosPosiciones extends Model
{
    public function cementerio()
    {
        return $this->hasOne("App\Cementerio");
    }
}
