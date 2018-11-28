<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Renta extends Model
{
  protected $fillable = ['tipo_pago','tramo','desde','hasta','porcentaje','exceso','cuota_fija'];

  public static function renta($tipo_saldo,$salario){//Recibe si el paso es 1=Mensual, 2=Quincenal, 3=Semanal y el salario
    $tra="'IV'";
    if($tipo_saldo==1){
      $var="'Mensual'";
      $ult=DB::select('select * from rentas where tipo_pago='.$var.' and tramo='.$tra);
      foreach ($ult as $tr) {$max= $tr->desde;}
      if($salario>=$max){
        return (($salario-$tr->exceso)*$tr->porcentaje/100)+$tr->cuota_fija;
      }else{
        $tramo=DB::select('select * from rentas where '.$salario.' between desde and hasta and tipo_pago='.$var);
        foreach ($tramo as $t) {
          return (($salario-$t->exceso)*$t->porcentaje/100)+$t->cuota_fija;
        }
      }
    }elseif($tipo_saldo==2){
      $var="'Quincenal'";
      $ult=DB::select('select * from rentas where tipo_pago='.$var.' and tramo='.$tra);
      foreach ($ult as $tr) {$max= $tr->desde;}
      if($salario>=$max){
        return (($salario-$tr->exceso)*$tr->porcentaje/100)+$tr->cuota_fija;
      }else{
        $tramo=DB::select('select * from rentas where '.$salario.' between desde and hasta and tipo_pago='.$var);
        foreach ($tramo as $t) {
          return (($salario-$t->exceso)*$t->porcentaje/100)+$t->cuota_fija;
        }
      }
    }
    else{
      $var="'Semanal'";
      $ult=DB::select('select * from rentas where tipo_pago='.$var.' and tramo='.$tra);
      foreach ($ult as $tr) {$max= $tr->desde;}
      if($salario>=$max){
        return (($salario-$tr->exceso)*$tr->porcentaje/100)+$tr->cuota_fija;
      }else{
        $tramo=DB::select('select * from rentas where '.$salario.' between desde and hasta and tipo_pago='.$var);
        foreach ($tramo as $t) {
          return (($salario-$t->exceso)*$t->porcentaje/100)+$t->cuota_fija;
        }
      }
    }
  }
}
