<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialUnidad extends Model
{
    protected $guarded=[];

    public function material()
    {
        return $this->belongsTo('App\Materiales','material_id');
    }

    public static function retornar_id(){
        $numero=MaterialUnidad::count();
        return date("Yidisus").'-'.$numero;
      }

    
}
