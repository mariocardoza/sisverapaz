<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contribuyente extends Model
{
    //protected $dates = ['deleted_at'];
    protected $dates = ['created_at','updated_at','fechabaja','nacimiento'];
	
    protected $guarded = [];

    public static function Buscar($nombre,$estado)
    {
        return Contribuyente::nombre($nombre)->estado($estado)->orderBy('id')->paginate(10);
    }

    public function scopeEstado($query,$estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeNombre($query,$nombre)
    {
    	if(trim($nombre) != "")
    	{
    		return $query->where('nombre','iLIKE', '%'.$nombre.'%');
    	}
        
    }

    public function inmueble()
    {
        return $this->hasMany('App\Inmueble');
    }

    public function inmuebles()
    {
        return $this->hasMany('App\Inmueble');
    }

    public function construccion()
    {
        return $this->hasMany('App\Construccion');
    }

    public function pago()
    {
        return $this->hasMany('App\Pago');
    }

    // para los negocios
    public function negocios(){
        return $this->hasMany('App\Negocio');
    }

    public static function modal_edit($id)
    {
        $contri=Contribuyente::find($id);
        $modal="";
        $modal.='<div class="modal fade" tabindex="-1" id="modal_editcontribuyente" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="gridSystemModalLabel">Editar contribuyente</h4>
            </div>
            <div class="modal-body">
                <form id="form_econtribuyente" class="">
                    <div class="row">
                        <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre" class="control-label">Nombre completo</label>
                            
                                <div class="">
                                    <input type="text" value="'.$contri->nombre.'" name="nombre" class="form-control" autocomplete="off">
                                    <input type="hidden" value="'.$contri->id.'" id="contri_id">
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dui" class="control-label">Número de DUI</label>
                            
                                <div class="">
                                <input type="text" value="'.$contri->dui.'" name="dui" class="form-control dui" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nit" class="control-label">Número de NIT</label>
                            
                                <div class="">
                                <input type="text" value="'.$contri->nit.'" name="nit" class="form-control nit" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefono" class="control-label">Teléfono</label>
                            
                                <div class="">
                                <input type="text" value="'.$contri->telefono.'" name="telefono" class="form-control telefono" autocomplete="off">

                                </div>
                            </div>
                            
                        </div>
                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nacimiento" class="control-label">Fecha de registro</label>
                            
                                <div class="">
                                <input type="text" value="'.($contri->nacimiento=='' ? '' : $contri->nacimiento->format('d-m-Y')).'" name="nacimiento" class="form-control fechita" autocomplete="off">

                                  
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sexo" class="control-label">Sexo</label>
                            
                                <div class="">
                                    <select name="sexo" id="" class="form-control">
                                        <option value="">Seleccione</option>';
                                        if($contri->sexo=='Másculino'):
                                            $modal.='<option selected value="Másculino">Másculino</option>
                                        <option value="Femenino">Femenido</option>';
                                        else:
                                            $modal.='<option  value="Másculino">Másculino</option>
                                        <option selected value="Femenino">Femenido</option>';
                                        endif;
                                    $modal.='</select>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="direccion" class="control-label">Dirección</label>
                            
                                <div class="">
                                    <textarea class="form-control" rows="3" autocomplete="off" name="direccion">'.$contri->direccion.'</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                  </div>
                
            </div>
            <div class="modal-footer">
              <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="button" id="eform_econtribuyente" class="btn btn-success">Registrar</button></center>
            </div>
          </form>
          </div>
        </div>
      </div>';

      return $modal;
    }
}
