<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Detalleplanilla extends Model
{
  protected $fillable = ['empleado_id','salario','tipo_pago','pago'];

  public static function empleados(){
    $empleados=Empleado::orderBy('nombre')->get();
    $a_empleados=[];
    foreach ($empleados as $e) {
      if($e->detalleplanilla->count()<1){
        if($e->contrato->count()<1){
          $a_empleados[$e->id]=$e->nombre;
        }
      }
    }
    return $a_empleados;
  }
  public function Empleado()
  {
      return $this->belongsTo('App\Empleado');
  }
  public static function empleadosPlanilla(){
    return DB::table('empleados')
    ->select('empleados.*','detalleplanillas.pago','detalleplanillas.salario','detalleplanillas.tipo_pago')
    ->join('detalleplanillas','empleados.id','=','detalleplanillas.empleado_id','left outer')
    ->where('empleados.estado',1)
    ->where('detalleplanillas.id','<>',null)
    ->where('detalleplanillas.tipo_pago',1)
    ->orderby('empleados.nombre')
    ->get();
  }
}
