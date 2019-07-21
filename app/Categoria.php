<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $guarded = [];

    public function Presupuestodetalle()
    {
    	return $this->hasMany('App\Presupuesto');
    }

    public static function categoria_nombre($id)
    {
      $categoria=Categoria::findorFail($id);
      $nombre = $categoria->item." ".$categoria->nombre_categoria;
      return $nombre;
    }

    public static function categorias(){
      $lascates=Categoria::where('estado',1)->get();
      $categorias=[];
      foreach ($lascates as $cate) {
        $categorias[$cate->id]=$cate->nombre_categoria;
      }
      return $categorias;
    }
}
