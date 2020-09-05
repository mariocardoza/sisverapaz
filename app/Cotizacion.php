<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $guarded = [];

    public static function Buscar($nombre,$estado)
    {
        return Cotizacion::nombre($nombre)->estado($estado)->orderBy('id')->paginate(10);
    }

    public function scopeEstado($query,$estado)
    {
        return $query->where('estado',$estado);
    }
    public function scopeNombre($query,$nombre)
    {
    	if(trim($nombre != "")){
            return $query->where('nombre','iLIKE', '%'.$nombre.'%');
    	}

    }

    public function detallecotizacion()
    {
        return $this->hasMany('App\Detallecotizacion');
    }

    public function solicitudcotizacion()
    {
        return $this->belongsTo('App\Solicitudcotizacion');
    }

    public function formapago()
    {
        return $this->belongsTo('App\Formapago','descripcion');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }

    public function ordencompra()
    {
        return $this->hasOne('App\Ordencompra')->where('estado','<>',2);
    }

    public static function total_cotizacion($id)
    {
        $cotizacion=Cotizacion::find($id);
        $total=0.0;
        foreach($cotizacion->detallecotizacion as $detalle)
        {
            $total=$total+($detalle->precio_unitario*$detalle->cantidad);
        }

        return $total;
    }

    public static function ver_cotizacion($id){
        $cotizacion=Cotizacion::find($id);
        $html="";
        $html.='<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_ver_coti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" >'.$cotizacion->proveedor->nombre.'</h4>
            </div>
            <div class="modal-body">';
            if($cotizacion->solicitudcotizacion->estado==1):
            $html.='<button type="button" id="anular_coti" data-id="'.$cotizacion->id.'" class="btn btn-danger"><i class="fa fa-remove"></i> Anular</button>';
            endif;
            $html.='<br>
              <table class="table">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Unidad de medida</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                  </tr>
                </thead>
                <tbody id="">';
                foreach ($cotizacion->Detallecotizacion as $detalle) {
                    $html.='<tr>
                        <td>'.mb_strtoupper($detalle->material->nombre).'</td>
                        <td>'.$detalle->marca.'</td>
                        <td>'.strtoupper($detalle->unidadmedida->nombre_medida).'</td>
                        <td>'.$detalle->cantidad.'</td>
                        <td>$'.number_format($detalle->precio_unitario,2).'</td>
                        </tr>';
                }
                $html.='</tbody>
              </table>
            </div>
            <div class="modal-footer">
              <center><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></center>
            </div>
          </div>
          </div>
        </div>';
        
        return array(1,"exito",$html,$cotizacion->proveedor->nombre);
    }
}
