<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndicadoresProyecto extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];
    public $incrementing = false;

    public static function obtener_indicadores($proyecto){
    	try{
    		$indicadores=IndicadoresProyecto::where('proyecto_id',$proyecto)->orderBy('created_at')->get();
        	return array(1,"exito",$indicadores);	
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
    			'proyecto_id'=>$data['elproyecto']
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
