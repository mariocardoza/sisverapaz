<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $guarded = [];
    protected $fillable = ['empleado_id','banco_id','numero_de_cuenta','monto','numero_de_cuotas','cuota'];

    public static function prestamos()
    {
      $prestamo = Prestamo::where('empleado_id',$id)->first();
    	$monto = $prestamo->monto;
      return $monto;
    }

    public function empleado()
    {
      return $this->belongsTo('App\Empleado');
    }
    public static function comprobarPrestamo($id){
    return $prestamo=Prestamo::where('empleado_id',$id)->where('estado',1)->get()->last();

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
