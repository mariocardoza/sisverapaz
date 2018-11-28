<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $guarded = [];
    protected $fillable = ['empleado_id','isss','afp','insaforp','prestamos','estado','datoplanilla_id','prestamo_id'];
}
