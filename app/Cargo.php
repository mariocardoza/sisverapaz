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

   /* public function contratoproyecto()
    {
    	$this->hasMany('App\Contratoproyecto');
    }*/
}