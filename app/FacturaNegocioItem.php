<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturaNegocioItem extends Model
{
    protected $guarded = [];
    
    public function facturanegocio()
    {
        return $this->belongsTo('App\FacturaNegocio');
    }

    public function rubro () {
		return $this->belongsTo('App\Rubro','rubro_id');
	}
}
