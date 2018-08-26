<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaTrabajo extends Model
{
    protected $guarded = [];

    public function categoriaempleado()
    {
        return $this->hasMany('App/CategoriaEmpleado');
    }
}
