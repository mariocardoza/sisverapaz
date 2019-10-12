<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fondo extends Model
{
    protected $guarded = [];
    
    public $incrementing = false;

    public function proyecto()
    {
    	return $this->belongsTo('App\Proyecto');
    }

    public function cuenta()
    {
    	return $this->belongsTo('App\Cuenta');
    }

    public static function retonrar_id_insertar(){
        $numero=Fondo::count();
        $numero+=1;
        return date("Yidisus").'-'.$numero;
    }
}
