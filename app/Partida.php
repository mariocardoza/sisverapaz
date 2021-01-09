<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $guarded = [];
    protected $dates = ['fecha_pago'];
}
