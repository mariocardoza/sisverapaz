<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cuenta extends Model
{
    protected $guarded=[];
    protected $dates =['fecha_de_apertura'];

    public function proyecto()
    {
      return $this->belongsTo('App\Proyecto');
    }

    public function pago()
    {
    	return $this->belongsTo('App\Pago');
    }

    public function banco()
    {
      return $this->belongsTo('App\Banco');
    }

    public function cuentadetalle()
    {
      return $this->hasMany('App\CuentaDetalle')->orderBy('created_at');
    }

    public static function modal_asignarfondos($id)
    {
        $modal="";
        $cuenta=Cuenta::find($id);
        $cuentas=Cuenta::where('estado',1)->whereYear('created_at',date("Y"))->get();

        $modal.='<div class="modal fade" tabindex="-1" id="modal_agregarfondo_cuenta" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="gridSystemModalLabel">Registrar cuenta</h4>
            </div>
            <div class="modal-body">
                <form id="form_add_cuentaproy" action="" class="">
                <div class="form-group">
                    <label class="control-label">Cuenta de origen</label>
                    <div>
                        <select class="chosen" id="select_fondo" name="cuenta_id">
                            <option value="">Seleccione una cuenta de origen</option>';
                            foreach($cuentas as $detalle):
                                if($detalle->id!=$cuenta->id):
                                $modal.='<option data-montocuenta="'.$detalle->monto_inicial.'" value="'.$detalle->id.'">'.$detalle->nombre.'</option>';
                                endif;
                              endforeach;
                        $modal.='</select>
                    </div><br>
                    <span><b id="imp_monto"></b></span>
                </div>

                    <div class="form-group">
                      <label class="control-label">Cuenta a abonar</label>
                      <div>
                        <input type="text" class="form-control" readonly value="'.$cuenta->nombre.'">
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

      return array(1,"exito",$modal);
    }

    public static function modal_remesar($id)
    {
      $modal="";
      $cuenta=Cuenta::find($id);
      $modal.='<div class="modal fade" tabindex="-1" id="modal_remesar_cuenta" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="gridSystemModalLabel">Remesar cuenta '.$cuenta->nombre.'</h4>
            </div>
            <div class="modal-body">
                <form id="form_remesar_cuenta" action="" class="">
                    <div class="form-group">
                        <label class="control-label">Monto a remesar</label>
                        <div>
                            <input type="number" class="form-control" min="1" name="monto">
                            <input type="hidden" class="form-control" value="'.$cuenta->id.'"  name="cuenta_id" >
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Detalle</label>
                      <div>
                            <textarea class="form-control" rows="2" name="detalle"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" id="remesar_cuenta" data-id="'.$cuenta->id.'" class="btn btn-primary">Remesar</button>
            </div>
          </div>
        </div>
      </div>';

      return array(1,"exito",$modal);
    }
}