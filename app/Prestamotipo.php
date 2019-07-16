<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamotipo extends Model
{
	protected $guarded = [];
    public $incrementing = false;

    public function prestamo()
    {
    	return $this->belongsTo('App\Prestamo');
    }

    public static function tipos(){
        $tipos=Prestamotipo::where('estado',1)->get();
        $arrayB= [];
        foreach($tipos as $tipo){
          $arrayB[$tipo->id]=$tipo->nombre;
        }
        return $arrayB;
    }
}
