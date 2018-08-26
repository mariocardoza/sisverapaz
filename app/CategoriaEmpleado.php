<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaEmpleado extends Model
{
    protected $guarded = [];

    public function empleado()
    {
    	return $this->belongsTo('App\Empleado');
    }

    public function categoriatrabajo()
    {
    	return $this->belongsTo('App\CategoriaTrabajo');
    }

    public function cargo()
    {
    	return $this->belongsTo('App\Cargo');
    }
}
