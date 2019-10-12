<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Proveedor extends Model
{

	protected $dates = ['created_at','updated_at','fechabaja'];
	
    protected $guarded = [];

    public static function Buscar($estado)
    {
        return Proveedor::estado($estado);
    }

    public function scopeEstado($query,$estado)
    {
        return $query->where('estado', $estado);
    }

    public function cotizacion()
    {
        return $this->hasMany('App\Cotizacion');
    }

    public function contratosuministro()
    {
        return $this->hasMany('App\Contratosuministro');
    }

    public static function mas_utilizados()
    {
        return DB::table('cotizacions as c')
        ->select('p.nombre',DB::raw('count(c.proveedor_id) as total'))
        ->join('proveedors as p','c.proveedor_id','=','p.id','inner')
        ->where('c.seleccionado',1)
        ->whereYear('c.created_at',date("Y"))
        ->groupby('c.proveedor_id')
        ->get();
    }
}
