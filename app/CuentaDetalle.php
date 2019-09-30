<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaDetalle extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];

    public static function total_cuenta($id)
    {
        $cuenta=Cuenta::find($id);
        $total=0.00;
        foreach($cuenta->cuentadetalle as $detalle){
            if($detalle->tipo==1){
                $total=$total+$detalle->monto;
            }else{
                $total=$total-$detalle->monto;
            }
        }

        return $total;
    }

    public static function retonrar_id_insertar(){
        $numero=CuentaDetalle::count();
        $numero+=1;
        return date("Yidisus").'-'.$numero;
    }
}
