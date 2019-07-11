<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisiciondetalle extends Model
{
    protected $fillable = ['id','requisicion_id','cantidad','materiale_id','unidad_medida'];
    protected $primaryKey = "id";
  	public $incrementing = false;
  	public $timestamps = false;

    public function Requisicione()
    {
      return $this->belongsTo('App\Requisicione');
    }

    public function material(){
        return $this->belongsTo('App\Materiales','materiale_id');
    }

    public function unidadmedida()
    {
    	return $this->belongsTo('App\UnidadMedida','unidad_medida');
    }

    public static function retonrar_id_insertar(){
    $numero=Requisiciondetalle::count();
    return date("Yidisus").'-'.$numero;
}
}
