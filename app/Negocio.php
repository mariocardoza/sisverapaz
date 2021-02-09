<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Negocio extends Model {
	protected $guarded = [];
	public function contribuyente() {
		return $this->belongsTo('App\Contribuyente');
	}

	public function rubro () {
		return $this->belongsTo('App\Rubro');
	}

	public function factura()
	{
		return $this->hasMany('App\FacturaNegocio','negocio_id');
	}

	public function mora()
    {
        return $this->hasOne('App\MoraNegocio');
	}
	
	public static function aplicar_mora($id)
    {
        $negocio=Negocio::find($id);
        $moras=0;
        $hoy = date('y-m-d');
		$moraactual=0.0;
        foreach($negocio->factura as $factura)
        {
            if($factura->fechaVencimiento < $hoy && $factura->estado == 1):
                $moras++;
                $moraactual = $moraactual+($factura->pagoTotal*retornar_porcentaje('mora'));
            endif;
        }
        $mora= new MoraNegocio();
        $mora->negocio_id = $negocio->id;
        $mora->porcentaje = el_porcentaje('mora');
        $mora->mora = $moraactual;
        $mora->save();
    }
}