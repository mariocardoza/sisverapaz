<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\DatesTranslator;

class Construccion extends Model
{
    use DatesTranslator;
    protected $guarded = [];
    protected $dates=['fecha_pago'];

    public function contribuyente()
    {
    	return $this->belongsTo('App\Contribuyente');
    }

    public function inmueble()
    {
    	return $this->belongsTo('App\Inmueble');
    }
}
