<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Inmueble extends Model
{
    protected $guarded = [];
    protected $fillable = ['estado'];
    
    public function contribuyente()
    {
    	return $this->belongsTo('App\Contribuyente');
    }

    public function mora()
    {
        return $this->hasOne('App\MoraInmueble');
    }
    public function factura()
    {
        return $this->hasMany('App\Factura','mueble_id');
    }

    public function tiposervicio()
    {
        return $this->belongsToMany('App\Tiposervicio')->withPivot('id')->withTimestamps();
    }
}
