<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    protected $fillable = ['tipo_pago','tramo','desde','hasta','porcentaje','exceso','cuota_fija'];
}
