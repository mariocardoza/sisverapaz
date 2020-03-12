<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatCargo extends Model
{
    protected $guarded = [];
    public $incrementing=false;

    public static function catcargos()
    {
        $loscargos=CatCargo::where('estado',1)->get();
        $cargos=[];
        foreach ($loscargos as $cargoo) {
            $cargos[$cargoo->id]=$cargoo->nombre;
        }

        return $cargos;
    }

    public function cargo()
    {
        return $this->hasMany('App\Cargo','catcargo_id');
    }

}
