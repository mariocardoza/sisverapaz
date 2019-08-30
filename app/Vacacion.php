<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    protected $fillable = ['detalleplanilla_id','estado','anio','fecha_vacacion'];
        //
}
