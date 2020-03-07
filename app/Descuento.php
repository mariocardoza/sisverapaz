<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    public function categoriadescuento()
    {
        return $this->belongsTo('App\CategoriaDescuento');
    }

    public static function comprobardescuento($id)
    {
        $tot=0.0;
        $descuentos=Descuento::where('empleado_id',$id)->where('estado',1)->whereMonth('fecha_fin','>=',date('m'))->get();
        if(count($descuentos)>0){
            foreach($descuentos as $p){
            $tot+=$p->cuota;
            }
        }
        return $tot;
    }
}
