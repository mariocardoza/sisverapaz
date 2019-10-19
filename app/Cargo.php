<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
	protected $guarded = [];
	
    public function categoriaempleado()
    {
    	return $this->hasMany('App\CategoriaEmpleado');
    }

    public static function cargos()
    {
        $loscargos=Cargo::where('estado',1)->get();
        foreach ($loscargos as $cargoo) {
            $cargos[$cargoo->id]=$cargoo->cargo;
        }

        return $cargos;
    }

    public function catcargo()
    {
        return $this->belongsTo('App\Catcargo');
    }

   /* public function contratoproyecto()
    {
    	$this->hasMany('App\Contratoproyecto');
    }*/
}