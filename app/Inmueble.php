<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Inmueble extends Model
{
    protected $guarded = [];
    protected $fillable = ['estado'];
    
    public function contribuyente()
    {
    	return $this->belongsTo('App\Contribuyente');
    }

    public function mora()
    {
        return $this->hasOne('App\MoraInmueble');
    }
    public function factura()
    {
        return $this->hasMany('App\Factura','mueble_id');
    }

    public function tiposervicio()
    {
        return $this->belongsToMany('App\Tiposervicio')->withPivot('id')->withTimestamps();
    }

    public static function aplicar_mora($id)
    {
        $inmueble=Inmueble::find($id);
        $moras=0;
        $hoy = date('y-m-d');
        $moraactual=0.0;
        foreach($inmueble->factura as $factura)
        {
            if($factura->fechaVencimiento < $hoy && $factura->estado == 1):
                $moras++;
                $moraactual = $moraactual+($factura->pagoTotal*retornar_porcentaje('mora'));
            endif;
        }
        $mora= new MoraInmueble();
        $mora->inmueble_id = $inmueble->id;
        $mora->porcentaje = el_porcentaje('mora');
        $mora->mora = $moraactual;
        $mora->save();
    }
}
