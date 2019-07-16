<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paacdetalle extends Model
{
  protected $guarded = [];
  public $timestamps = false;
  public $incrementing = false;
    public function paac()
    {
        return $this->belongsTo('App\Paac');
    }

    public static function retornar_id(){
      $numero=Paacdetalle::count();
      return date("Yidisus").'-'.$numero;
    }
}
