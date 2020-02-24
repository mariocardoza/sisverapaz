<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoRenta extends Model
{
    protected $fillable = ['nombre','dui','nit','total','renta','liquido','concepto'];

    public function desembolso()
    {
    	return $this->belongsTo("App\Desembolso");
    }
}
