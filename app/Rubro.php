<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    protected $guarded = [];

    public static function Buscar($nombre,$estado)
    {
        return Rubro::nombre($nombre)->estado($estado)->orderBy('id')->paginate(10);
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
    public function negocios () {
        return $this->hasMany('App\Negocio');
    }

    public function categoriarubro()
    {
        return $this->belongsTo('App\CategoriaRubro');
    }

    public function negocios_activos() {
        return $this->hasMany('App\Negocio')->where('estado',1);
    }

}
