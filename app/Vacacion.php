<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    protected $fillable = ['detalleplanilla_id','estado','anio','fecha_vacacion'];

    public function detalleplanilla(){
        return $this->belongsTo('App\Detalleplanilla');
    }

}
