<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detallecotizacion extends Model
{
    protected $guarded =[];

    public function cotizacion()
    {
    	return $this->belongsTo('App\Cotizacion');
    }

    public function unidadmedida(){
    	return $this->belongsTo("App\Unidadmedida",'unidad_medida');
    }

    public function material()
    {
        return $this->belongsTo('App\Materiales','material_id');
    }

    public static function total_cotizacion($id)
    {   $total=$renta=0.0;
        $cotizacion=Cotizacion::find($id);
        foreach($cotizacion->detallecotizacion as $detalle){
            $total=$total+$detalle->precio_unitario*$detalle->cantidad;
        }
        $renta=$total*0.1;
        $total=$total-$renta;
        return $total;
    }
}
