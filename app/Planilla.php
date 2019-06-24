<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $guarded = [];
    protected $fillable = ['empleado_id','issse','afpe','isssp','afpp','insaforpp','renta','prestamos','estado','datoplanilla_id','prestamo_id'];
    public function empleado()
    {
      return $this->belongsTo('App\Empleado');
    }
}
