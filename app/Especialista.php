<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialista extends Model
{
    protected $guarded = [];

    public static function Buscar($nombre,$estado)
    {
    	return Especialista::nombre($nombre)->estado($estado)->orderBy('id')->paginate(10);
    }
}
