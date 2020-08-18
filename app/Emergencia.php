<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emergencia extends Model
{
    protected $guarded =[];

    protected $dates=['fecha_inicio','fecha_fin'];
}
