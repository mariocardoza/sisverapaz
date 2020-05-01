<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumbrado extends Model
{
    protected $guarded=[];
    protected $dates=['fecha','fecha_reparacion'];
}
