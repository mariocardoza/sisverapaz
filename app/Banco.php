<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
	protected $guarded=[];
	
    public static function bancos(){
      $bancos=Banco::where('estado',true)->orderBy('nombre')->get();
      $arrayB= [];
      foreach($bancos as $banco){
        $arrayB[$banco->id]=$banco->nombre;
      }
      return $arrayB;
    }


  }
