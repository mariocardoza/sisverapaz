<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndicadoresProyecto extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];

    public function obtener_indicadores(){
    	$indicadores=IndicadoresProyecto::where('estado',1)->orderBy('nombre')->get();
        return $indicadores; 
    }

    
}
