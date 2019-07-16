<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $fillable = ['nombre_medida'];

    public static function medidas(){
    	$lasmedidas=UnidadMedida::all();
    	foreach ($lasmedidas as $medida) {
    		$medidas[$medida->id]=$medida->nombre_medida;
    	}
    	return $medidas;
    }
}
