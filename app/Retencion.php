<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retencion extends Model
{
    protected $guarded = [];
    //Función que recibe el id de la retención a aplicar y el salario del empleado y retorna el valor de la retención
    public static function Valor($id,$salario){
      $retencion=Retencion::find($id);
      if($salario<$retencion->techo){
        return ($retencion->porcentaje/100)*$salario;
      }else{
        return ($retencion->porcentaje/100)*$retencion->techo;
      }
    }
    //Función que recibe el nombre que se usa en el input y retorna el nombre completo para mostrar en la tabla de planillas
    public static function nombreCompleto($nombre){
      if($nombre=="ISSSE"){
        return "ISSS Empleado";
      }else if($nombre=="ISSSP"){
        return "ISSS Patronal";
      }
      else if($nombre=="AFPE"){
        return "AFP Empleado";
      }
      else if($nombre=="AFPP"){
        return "AFP Patronal";
      }
      else if($nombre=="INSAFORPP"){
        return "INSAFORP Patronal";
      }

    }
}
