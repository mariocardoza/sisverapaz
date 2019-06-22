<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndicadoresProyecto extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];
    protected $primaryKey = "codigo";
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
    			'codigo'=>date("Yidisus"),
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

    public static function eliminar($id){
        $indicador=IndicadoresProyecto::find($id);
        try{
            $indicador->delete();
            return array(1,"exito",$indicador);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    
}
