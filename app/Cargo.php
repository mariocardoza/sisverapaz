<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
	protected $guarded = [];
	
    public function categoriaempleado()
    {
    	return $this->hasMany('App\CategoriaEmpleado');
    }

    public static function cargos()
    {
        $loscargos=Cargo::where('estado',1)->get();
        $cargos=[];
        foreach ($loscargos as $cargoo) {
            $cargos[$cargoo->id]=$cargoo->cargo;
        }

        return $cargos;
    }

    public function detalleplanilla()
    {
        return $this->hasMany('App\Detalleplanilla');
    }

    public function catcargo()
    {
        return $this->belongsTo('App\CatCargo');
    }

    public static function selectcargo($id)
    {
        $html='';
        $html.='Seleccione un cargo';
        $cat=CatCargo::find($id);
        foreach($cat->cargo as $c){
            $html.='<option value="'.$c->id.'">'.$c->cargo.'</option>';
        }
        return array(1,"exito",$html);
    }

   /* public function contratoproyecto()
    {
    	$this->hasMany('App\Contratoproyecto');
    }*/
}