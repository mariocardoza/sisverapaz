<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $fillable = ['nombre_unidad'];

    public function presupuestounidad()
    {
    	return $this->hasMany('App\Presupuestounidad');
    }

    public function requisicion(){
      return $this->hasMany('App\Requisicion');
    }

    public function usuario()
    {
      return $this->hasMany('App\User','unidad_id');
    }

}
