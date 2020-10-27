<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $guarded = [];
    protected $dates = ['fecha_contrato','fecha_nacimiento'];

    public static function Buscar($nombre,$estado)
    {
    	return Empleado::nombre($nombre)->estado($estado)->orderBy('id')->paginate(10);
    }

    public function getImgPathAttribute(){
    	return \Storage::url('avatars/'.$this->avatar);
    }

    public function scopeEstado($query,$estado)
    {
    	return $query->where('estado',$estado);
    }

    public function scopeNombre($query,$nombre)
    {
    	if(trim($nombre != ""))
    	{
    		return $query->where('nombre','iLIKE', '%'.$nombre.'%');
    	}
    }

    public function prestamo()
    {
      return $this->hasMany('App\Prestamo');
    }

    public function prestamo_vigente()
    {
      return $this->hasMany('App\Prestamo')->where('fecha_fin','>=',date("Y-m"));
    }

    public function descuento()
    {
      return $this->hasMany('App\Descuento');
    }

    public function detalle()
    {
      return $this->HasOne('App\Detalleplanilla');
    }

    public function user(){
        return $this->hasOne('App\User');
    }

    /*public function contrato()
    {
        return $this->hasMany('App\Contrato');
    }

    public function contratoproyecto()
    {
        return $this->hasMany('App\Contratoproyecto');
    }*/

    public function categoriaEmpleado()
    {
        return $this->belongsTo('App\categoriaEmpleado');
    }
    public function detalleplanilla()
    {
      return $this->hasOne('App\Detalleplanilla');
    }
    
    public function contrato()
    {
      return $this->hasMany('App\Contrato');

    }
     public function banco(){
        return $this->belongsTo('App\Banco')->withDefault();
    }

    public function afp(){
    return $this->belongsTo('App\Afp');
    }
}
