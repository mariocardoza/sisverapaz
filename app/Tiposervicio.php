<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiposervicio extends Model
{
    protected $guarded = [];

    public function servicio()
    {
        return $this->hasMany('App\Servicio');
    }

    public function inmuebles()
    {
        return $this->belongsToMany('App\Inmueble')->withTimestamps();
    }
}
