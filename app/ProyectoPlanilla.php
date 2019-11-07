<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProyectoPlanilla extends Model
{
    public $incrementing=false;
    protected $guarded=[];

    public function proyecto()
    {
        return $this->belongsTo('App\Proyecto');
    }

    public function cargo()
    {
        return $this->belongsTo('App\CargoProyecto');
    }

    public function catorcena()
    {
        return $this->belongsTo('App\PeriodoProyecto','catorcena_id');
    }

    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }

    public static function retornar_id()
    {
        $numero=ProyectoPlanilla::count();
        $numero+=1;
        return date("Yidisus").'-'.$numero;
    }
}
