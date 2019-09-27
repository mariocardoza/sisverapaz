<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaproyDetalle extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];

    public static function total_cuenta($id)
    {
        $cuenta=Cuentaproy::find($id);
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
}
