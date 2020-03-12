<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datoplanilla extends Model
{
    protected $fillable = ['fecha', 'tipo_pago','mes','anio'];

    public static function totalplanilla($id)
    {
        $total=0;
        $dato=Datoplanilla::find($id);
        foreach($dato->planilla as $p){
            $total+=$p->empleado->detalleplanilla->salario+$p->isssp+$p->afpp+$p->insaforpp;
        }
        return $total;
    }

    public function planilla()
    {
        return $this->hasMany('App\Planilla');
    }

    public function detalleplanilla()
    {
        return $this->hasMany('App\Detalleplanilla');
    }

    public static function obtenerMes($n){
        if($n==1){
            return "enero";
        }elseif($n==2){
            return "febrero";
        }elseif($n==3){
            return "marzo";
        }elseif($n==4){
            return "abril";
        }elseif($n==5){
            return "mayo";
        }elseif($n==6){
            return "junio";
        }elseif($n==7){
            return "julio";
        }elseif($n==8){
            return "agosto";
        }elseif($n==9){
            return "septiembre";
        }elseif($n==10){
            return "octubre";
        }elseif($n==11){
            return "noviembre";
        }elseif($n==12){
            return "diciembre";
        }
    }
    public static function comprobar($letra){
        $fecha=\Carbon\Carbon::now();
        if($letra=='m'){
            $cuenta=Datoplanilla::where('fecha', 'like',$fecha->format('Y-m-').'%')->count();
            if($cuenta>0){
                return false;
            }else{
                return true;
            }
        }elseif($letra=='q'){
            return true;
        }
    }
}
