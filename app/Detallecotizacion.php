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

    public static function renta_cotizacion($id)
    {
        $total=$renta=0.0;
        $cotizacion=Cotizacion::find($id);
        foreach($cotizacion->detallecotizacion as $detalle){
            if($detalle->material->servicio==1){
                $renta=$renta+(($detalle->precio_unitario*$detalle->cantidad)*session('renta'));
            }
        }
        return $renta;
    }

    public static function total_cotizacion($id)
    {   $total=$renta=0.0;
        $cotizacion=Cotizacion::find($id);
        foreach($cotizacion->detallecotizacion as $detalle){
            $total=$total+$detalle->precio_unitario*$detalle->cantidad;
            if($detalle->material->servicio==1){
                $renta=$renta+(($detalle->precio_unitario*$detalle->cantidad)*retornar_porcentaje('renta'));
            }
        }
        
        $total=$total-$renta;
        return $total;
    }
}
