<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Proveedor extends Model
{

	protected $dates = ['created_at','updated_at','fechabaja'];
	
    protected $guarded = [];

    public static function Buscar($estado)
    {
        return Proveedor::estado($estado);
    }

    public function scopeEstado($query,$estado)
    {
        return $query->where('estado', $estado);
    }

    public function giro()
    {
        return $this->belongsTo('App\Giro');
    }

    public function cotizacion()
    {
        return $this->hasMany('App\Cotizacion')->orderby('created_at','desc');
    }

    public function contratosuministro()
    {
        return $this->hasMany('App\Contratosuministro');
    }

    public static function mas_utilizados()
    {
        return DB::table('cotizacions as c')
        ->select('p.nombre',DB::raw('count(c.proveedor_id) as total'))
        ->join('proveedors as p','c.proveedor_id','=','p.id','inner')
        ->where('c.seleccionado',1)
        ->whereYear('c.created_at',date("Y"))
        ->groupby('c.proveedor_id')
        ->get();
    }

    public static function modal_editar($id)
    {
        $proveedor=Proveedor::find($id);
        $modal='';
        $modal.='<div class="modal fade" tabindex="-1" id="modal_proveedor" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="gridSystemModalLabel">Editar datos del proveedor</h4>
            </div>
            <div class="modal-body">
                <form id="form_edit">
                <div class="form-group">
                <label for="nombre" class="control-label">Nombre de la Empresa o Proveedor</label>
                <div class="">
                    <input type="text" value="'.$proveedor->nombre.'" name="nombre" class="form-control" autocomplete="off">
                </div>
            </div>
        
            <div class="form-group">
                <label for="direccion" class="control-label">Dirección</label>
        
                <div class="">
                <textarea class="form-control" name="direccion" rows="2" autocomplete="off">'.$proveedor->direccion.'</textarea>
                </div>
            </div>
        
                <div class="form-group">
                    <label for="telefono" class="control-label">Teléfono</label>
        
                    <div class="">
                    <input type="text" name="telefono" value="'.$proveedor->telefono.'" class="form-control telefono" autocomplete="off">
                </div>
                </div>
        
                <div class="form-group">
                    <label for="email" class="control-label">E-Mail Proveedor</label>
        
                    <div class="">
                        <input type="email" name="email" value="'.$proveedor->email.'" class="form-control " autocomplete="off"> 

                    </div>
                </div>
                  <div class="form-group">
                      <label for="numero_registro" class="control-label">Número de registro del proveedor</label>
        
                      <div class="">
                      <input type="text" value="'.$proveedor->numero_registro.'" name="numero_registro" class="form-control " autocomplete="off">

                      </div>
                  </div>
                  <div class="form-group">
                      <label for="numero_registro" class="control-label">DUI (Si es persona natural)</label>
        
                      <div class="">
                      <input type="text" value="'.$proveedor->dui.'" name="dui" class="form-control dui" autocomplete="off">

                      </div>
                  </div>
                  <div class="form-group">
                      <label for="nit" class="control-label">Número de NIT</label>
        
                      <div class="">
                      <input type="text" value="'.$proveedor->nit.'" name="nit" class="form-control nit" autocomplete="off">

                      </div>
                  </div>
                </form>
            </div>
            <div class="modal-footer">
              <center>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="button" data-id="'.$proveedor->id.'" id="editar_proveedor" class="btn btn-primary">Editar</button></center>
            </div>
          </div>
        </div>
      </div>';
      return array(1,"exito",$modal);
    }
}
