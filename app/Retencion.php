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
}
