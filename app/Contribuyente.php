<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contribuyente extends Model
{
    //protected $dates = ['deleted_at'];
    protected $dates = ['created_at','updated_at','fechabaja','nacimiento'];
	
    protected $guarded = [];

    public static function Buscar($nombre,$estado)
    {
        return Contribuyente::nombre($nombre)->estado($estado)->orderBy('id')->paginate(10);
    }

    public function scopeEstado($query,$estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeNombre($query,$nombre)
    {
    	if(trim($nombre) != "")
    	{
    		return $query->where('nombre','iLIKE', '%'.$nombre.'%');
    	}
        
    }

    public function inmueble()
    {
        return $this->hasMany('App\Inmueble');
    }

    public function inmuebles()
    {
        return $this->hasMany('App\Inmueble');
    }

    public function construccion()
    {
        return $this->hasMany('App\Construccion');
    }

    public function pago()
    {
        return $this->hasMany('App\Pago');
    }

    // para los negocios
    public function negocios(){
        return $this->hasMany('App\Negocio');
    }
}
