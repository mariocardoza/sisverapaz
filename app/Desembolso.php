<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desembolso extends Model
{
    protected $guarded=[];
    protected $dates= ["fecha_desembolso"];
    public $incrementing = false;

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta');
    }

    public function cuentaproy()
    {
        return $this->belongsTo('App\Cuentaproy','cuentaproy_id');
    }

    public static function estado($id)
    {
        $desembolso=Desembolso::find($id);
        $html="";
        switch($desembolso->estado){
            case 1:
                $html.='<span class="col-xs-12 label-primary">En espera</span>';
                break;
            case 2:
                $html.='<span class="col-xs-12 label-danger">Rechazado</span>';
                break;
            case 3:
                $html.='<span class="col-xs-12 label-info">Desembolso efectuado</span>';
                break;
        }

        return $html;
    }
}
