<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at','fecha_contrato'];
}
