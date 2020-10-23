<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndicadoresProyecto extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];
    public $incrementing = false;

    public static function obtener_indicadores($proyecto){
        $html=$laclase="";
        $porcentaje=0;
    	try{
            $proyecto=Proyecto::find($proyecto);
            $indicadores=IndicadoresProyecto::where('proyectos_id',$proyecto)->orderBy('created_at')->get();
            if($proyecto->indicadores->count() > 0):
                $html.='<ul class="todo-list" id="los_indicadores">';
                foreach($proyecto->indicadores as $indicador):
                    $laclase="";
                    $porcentaje+=$indicador->porcentaje;
                if($indicador->estado==2):
                    $laclase="done";
                endif;
                $html.='<li data-estado="'.$indicador->estado.'" class="'.$laclase.'">
                    <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                    </span>
                <input type="checkbox" data-id="'.$indicador->id.'" id="indicador_completado" value="">
                <span class="text">'.$indicador->nombre.'</span>
                <small class="label label-danger"><i class="glyphicon glyphicon-ok"></i> '.$indicador->porcentaje.' %</small>
                <div class="tools">
                    <i data-id="'.$indicador->id.'" id="editar_indicador" class="fa fa-edit"></i>
                    <i data-id="'.$indicador->id.'" id="eliminar_indicador" class="fa fa-trash-o"></i>
                </div>
                </li>';
                endforeach;
               $html.='</ul>';
                if($proyecto->indicadores->sum('porcentaje') < 100):
                $html.='<button type="button" id="add_indicador" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Agregar indicador</button>';
                endif;
            else:
                $html.='<center>
                    <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                    <span>Agregue los nuevos indicadores para visualizar la información</span><br>
                    <button type="button" id="add_indicador" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Agregar indicador</button>
                </center>';
            endif;
            
        	return array(1,"exito",$proyecto->indicadores,$html,$porcentaje);	
    	}catch(Exception $e){
            return array(-1,"error",$e->getMessage());   
    		return $e->getMessage();
    	}
    	
    }

    public static function guardar($data){
    	try{
    		$indicador=IndicadoresProyecto::create([
    			'id'=>date("Yidisus"),
    			'nombre'=>$data['nombre'],
    			'porcentaje'=>$data['porcen'],
    			'descripcion'=>$data['descripcion'],
    			'proyectos_id'=>$data['elproyecto']
    		]);
    		return array(1,"exito",$indicador);
    	}catch(Exception $e){
    		return array(-1,"error",$e->getMessage());
    	}
    }

    public static function modal_editar($id){
        try{
            $indicador=IndicadoresProyecto::find($id);
        return array(1,"exito",$indicador);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }

    }

    public static function editar($request,$id){
        $indicador=IndicadoresProyecto::find($id);
        try{
            $indicador->nombre=$request->nombre;
            $indicador->descripcion=$request->descripcion;
            $indicador->porcentaje=$request->porcen;
            $indicador->save();
            return array(1,"exito",$indicador);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public static function completado($id){
        $indicador=IndicadoresProyecto::find($id);
        try{
            $indicador->estado=2;
            $indicador->save();
            return array(1,"exito");
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public static function eliminar($id){
        $indicador=IndicadoresProyecto::find($id);
        try{
            $indicador->delete();
            return array(1,"exito",$indicador);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public static function los_indicadores($id)
    {
        try{
            $indicadores=IndicadoresProyecto::find($id);
            $html="";
            $html.='';
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    
}
