<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $guarded = [];

    public static function Buscar($nombre,$estado)
    {
        return Cotizacion::nombre($nombre)->estado($estado)->orderBy('id')->paginate(10);
    }

    public function scopeEstado($query,$estado)
    {
        return $query->where('estado',$estado);
    }
    public function scopeNombre($query,$nombre)
    {
    	if(trim($nombre != "")){
            return $query->where('nombre','iLIKE', '%'.$nombre.'%');
    	}

    }

    public function detallecotizacion()
    {
        return $this->hasMany('App\Detallecotizacion');
    }

    public function solicitudcotizacion()
    {
        return $this->belongsTo('App\Solicitudcotizacion');
    }

    public function formapago()
    {
        return $this->belongsTo('App\Formapago','descripcion');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }

    public function ordencompra()
    {
        return $this->hasOne('App\Ordencompra');
    }

    public static function total_cotizacion($id)
    {
        $cotizacion=Cotizacion::find($id);
        $total=0.0;
        foreach($cotizacion->detallecotizacion as $detalle)
        {
            $total=$total+($detalle->precio_unitario*$detalle->cantidad);
        }

        return $total;
    }

    public static function ver_cotizacion($id){
        $cotizacion=Cotizacion::find($id);
        $html="";
        foreach ($cotizacion->Detallecotizacion as $detalle) {
            $html.='<tr>
                <td>'.mb_strtoupper($detalle->material->nombre).'</td>
                <td>'.$detalle->marca.'</td>
                <td>'.strtoupper($detalle->unidadmedida->nombre_medida).'</td>
                <td>'.$detalle->cantidad.'</td>
                <td>$'.number_format($detalle->precio_unitario,2).'</td>
                </tr>';
        }
        return array(1,"exito",$html,$cotizacion->proveedor->nombre);
    }
}
