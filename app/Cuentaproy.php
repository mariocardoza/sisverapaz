<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuentaproy extends Model
{
    protected $guarded = [];
    protected $dates =['fecha_de_apertura'];

    public function proyecto()
    {
    	return $this->belongsTo('App\Proyecto');
    }

    public function pago()
    {
    	return $this->hasOne('App\Pago');
    }

    public function banco()
    {
      return $this->belongsTo('App\Banco');
    }

    public function cuentadetalle()
    {
        return $this->hasMany('App\CuentaproyDetalle','cuentaproy_id');
    }

    public static function modal_asignarfondos($id)
    {
        $modal="";
        $cuenta=Cuentaproy::find($id);

        $modal.='<div class="modal fade" tabindex="-1" id="modal_agregarfondo_cuentaproy" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="gridSystemModalLabel">Asignar fondos a cuenta '.$cuenta->proyecto->nombre.'</h4>
            </div>
            <div class="modal-body">
                <form id="form_add_cuentaproy" action="" class="">
                    <div class="form-group">
                        <label class="control-label">Cuenta</label>
                        <div>
                            <select class="chosen" id="select_fondo" name="cuenta_id">
                                <option value="">Seleccione una cuenta de origen</option>';
                                foreach($cuenta->proyecto->fondo as $detalle):
                                    $modal.='<option data-montocuenta="'.$detalle->cuenta->monto_inicial.'" data-cuenta="'.$detalle->cuenta->id.'" data-disponible="'.$detalle->monto_disponible.'" data-tope="'.$detalle->monto.'" value="'.$detalle->id.'">'.$detalle->cuenta->nombre.'</option>';
                                endforeach;
                            $modal.='</select>
                        </div><br>
                        <span><b id="imp_monto"></b></span>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Digite el acuerdo de aprobación del abono</label>
                        <div>
                          <input type="text" class="form-control" name="n_acuerdo" id="n_acuerdo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Monto a transferir</label>
                        <div>
                            <input type="number" class="form-control" min="0" name="monto" id="elmonto_abonar">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" id="abonar_cuenta" data-id="'.$cuenta->id.'" class="btn btn-primary">Abonar</button>
            </div>
          </div>
        </div>
      </div>';

      return array(1,"exito",$modal,$cuenta->proyecto->fondo);
    }
}
