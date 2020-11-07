<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class afp extends Model
{
    protected $primaryKey = "codigo";
    protected $guarded = [];
    public $incrementing = false;

    public static function guardar($request){
    	try{
    		$afp=afp::create([
                'codigo'=>date('Yidisus'),
                'nombre'=>$request['nombre']
            ]);
    		return array(1,"exito",$afp);
    	}catch(Exception $e){
    		return array(-1,"error",$e->getMessage());
    	}
    }

     public function empleado()
     {
         return $this->hasMany('App\Empleado','afp_codigo');
     }
}
