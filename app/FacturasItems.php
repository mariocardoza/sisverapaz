<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

class FacturasItems extends Model
{
    protected $guarded = [];
    public $table = "factura_items";

    public function tiposervicio()
    {
        return $this->belongsToMany('App\Inmueble');
    }

    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }

    public static function servicio($tipoinmueble_id){
        $servicio_id=DB::table('inmueble_tipo_servicio')->where('id',$tipoinmueble_id)->get()->first()->tiposervicio_id;
        
        return tiposervicio::find($servicio_id)->nombre;
    }
}