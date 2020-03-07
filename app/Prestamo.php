<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable = ['empleado_id','banco_id','numero_de_cuenta','monto','numero_de_cuotas','cuota','tasa_interes','fecha_inicio','fecha_fin','prestamotipo_id','fecha_corte'];
    protected $dates = ['fecha_inicio','fecha_fin'];
    public static function prestamos()
    {
      $prestamo = Prestamo::where('empleado_id',$id)->get();
      foreach ($prestamo as $presta) {
        $monto = $monto+ $presta->monto;
      }
    	
      return $monto;
    }

    

    public function prestamotipo(){
      return $this->belongsTo('App\Prestamotipo');
    }

    public function empleado()
    {
      return $this->belongsTo('App\Empleado');
    }
    public static function comprobarPrestamo($id){
      $tot=0.0;
    $prestamos=Prestamo::where('empleado_id',$id)->where('estado',1)->whereMonth('fecha_fin','>=',date('m'))->get();
      if(count($prestamos)>0){
        foreach($prestamos as $p){
          $tot+=$p->cuota;
        }
      }
      return $tot;
    }
    public function banco()
    {
      return $this->belongsTo('App\Banco');
    }
    public static function actualizar(){
      $prestamos = Prestamo::where('estado',1)->get();
      foreach($prestamos as $prestamo){
        $cantidad=Planilla::where('prestamo_id',$prestamo->id)->get()->count();
        echo $cantidad."-";
        echo $prestamo->numero_de_cuotas;
        if($cantidad==$prestamo->numero_de_cuotas){
          $prestamo->estado=2;
          $prestamo->save();
        }
      }
    }
}
