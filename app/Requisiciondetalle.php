<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisiciondetalle extends Model
{
    protected $fillable = ['requisicion_id','cantidad','descripcion','unidad_medida'];

    public function Requisicione()
    {
      return $this->belongsTo('App\Requisicione');
    }
}
