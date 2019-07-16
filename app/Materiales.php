<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materiales extends Model
{
	protected $table="materiales";
    public $incrementing = false;
    protected $guarded=[];

    public function unidadmedida(){
    	return $this->belongsTo('App\UnidadMedida','unidad_id');
    }

    public function categoria(){
    	return $this->belongsTo('App\Categoria');
    }
}
