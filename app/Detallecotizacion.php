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
}
