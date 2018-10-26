<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalleplanilla extends Model
{
  protected $fillable = ['empleado_id','salario','tipo_pago','pago'];

  public static function empleados(){
    $empleados=Empleado::orderBy('nombre')->get();
    $a_empleados=[];
    foreach ($empleados as $e) {
      if($e->detalleplanilla->count()<1){
        $a_empleados[$e->id]=$e->nombre;
      }
    }
    return $a_empleados;
  }
}
