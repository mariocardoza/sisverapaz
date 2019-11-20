<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoProyecto extends Model
{
    protected $guarded = [];
    public $incrementing = false;
    protected $dates = ['fecha_inicio','fecha_fin'];

    public static function estado($id)
    {
        $mensaje="";
        $jornada=PeriodoProyecto::find($id);
        switch($jornada->estado){
            case 1:
            $mensaje.='<span class="col-xs-12 label-primary">Pendiente asignar empleados</span>';
            break;
            case 2:
            $mensaje.='<span class="col-xs-12 label-warning">Pendiente de pago</span>';
            break;
            case 3:
            $mensaje.='<span class="col-xs-12 label-warning">En espera de desembolso</span>';
            break;
            case 4:
            $mensaje.='<span class="col-xs-12 label-success">Pago realizado</span>';
        }

        return $mensaje;
    }

    public function proyecto()
    {
        return $this->belongsTo('App\Proyecto');
    }

    public static function pendientes($proyecto_id)
    {
        $periodos=PeriodoProyecto::where('proyecto_id',$proyecto_id)->whereIn('estado',[1,2])->get();
        return $periodos;
    }

    public static function calcular_total($id)
    {
        $neto=$liquido=$renta=0.0;
        $catorcena=PeriodoProyecto::find($id);
        foreach($catorcena->proyectoplanilla as $c){
            $neto+=$c->numero_dias*$c->salario_dia;
        }
        return $neto;
    }

    public function proyectoplanilla()
    {
        return $this->hasMany('App\ProyectoPlanilla','catorcena_id')->orderby('cargo_id');
    }
}
