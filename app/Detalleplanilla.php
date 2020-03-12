<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Detalleplanilla extends Model
{
  protected $fillable = ['empleado_id','salario','tipo_pago','pago','fecha_inicio','proyecto_id','numero_acuerdo','unidad_id','cargoproyecto_id'];
  protected $dates = ['fecha_inicio'];
  public static function empleados(){
    $empleados=Empleado::where('estado',1)->orderBy('nombre')->get();
    
    $a_empleados=[];
    foreach ($empleados as $e) {
      if(!$e->detalleplanilla && $e->contrato->count()<1){
          $a_empleados[$e->id]=$e->nombre;
      }
    }
    return $a_empleados;
  }

  public function Empleado()
  {
      return $this->belongsTo('App\Empleado');
  }

  public function unidad()
  {
    return $this->belongsTo('App\Unidad');
  }

  public function proyecto(){
    return $this->belongsTo('App\Proyecto');
  }

  public function cargo(){
    return $this->belongsTo('App\Cargo');
  }

  public function cargoproyecto()
  {
    return $this->belongsTo('App\CargoProyecto','cargoproyecto_id');
  }

  // public static function vacacion($id){//Recibe el id de planilla
  //   $mes = \Carbon\Carbon::now()->addMonths(1)->format('m');
  //  return Vacacion::where('estado',1)->where('detalleplanilla_id',$id)->whereBetween('fecha_vacacion', [date('Y').date('m').date('d'),'31'.$mes.date('d')])->get()->first();
  // }
  
  public static function empleadosPlanilla(){
    return DB::table('empleados')
    ->select('empleados.*','detalleplanillas.pago','detalleplanillas.salario','detalleplanillas.tipo_pago','detalleplanillas.fecha_inicio','detalleplanillas.id as elid')
    ->join('detalleplanillas','empleados.id','=','detalleplanillas.empleado_id','left outer')
    ->where('empleados.estado',1)
    ->where('detalleplanillas.id','<>',null)
    ->where('detalleplanillas.tipo_pago',1)
    ->orderby('empleados.nombre')
    ->get();
  }

  public static function pago($id){//Recibe detalle planilla id
    $detalle=Detalleplanilla::find($id);
    $salario=$detalle->salario;
    if($detalle->pago==1){
      $salario=$salario/2;
    }
    return $salario+($salario*0.3);
  }
}
