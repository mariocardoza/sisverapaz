<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratacionDirecta extends Model
{
    protected $guarded = [];

    public function emergencia()
    {
        return $this->belongsTo('App\Emergencia','emergencia_id')->withDefault();
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor')->withDefault();
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta')->withDefault();
    }

    public function formapagos()
    {
        return $this->belongsTo('App\Formapago','formapago')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo('App\User')->withDefault();
    }

    public function detalle()
    {
        return $this->hasMany('App\ContratacionDetalle','contratacion_id');
    }

    public function materiales()
    {
        return $this->hasMany('App\CompraDirecta','contratacion_id');
    }

    public function orden()
    {
      return $this->hasOne('App\Ordencompra','contratacion_id');
    }

    public static function codigo_proyecto()
    {
      
        $numero=ContratacionDirecta::where('created_at','>=',date('Y'.'-1-1'))->where('created_at','<=',date('Y'.'-12-31'))->count();
        $numero=$numero+1;
        if($numero>0 && $numero<10){
            return "CD-00".($numero)."-".date("Y");
        }else{
            if($numero >= 10 && $numero <100){
                return "CD-0".($numero)."-".date("Y");
            }else{
                if($numero>=100){
                    return "CD-".($numero)."-".date("Y");
                }else{
                    return "CD-001-".date("Y");
                }
            }
        }
    }

    public static function total($id)
    {
        $total=0;
        $compra=ContratacionDirecta::find($id);
        foreach($compra->materiales  as $i=>$m){
            $total=$total+$m->precio*$m->cantidad;
        }
        return $total;
    }

    public static function renta($id)
    {
        $renta=0;
        $compra=ContratacionDirecta::find($id);
        foreach($compra->materiales  as $i=>$m){
            if($m->material->servicio==1):
                $renta=$renta+$m->precio*$m->cantidad;
            endif;
        }
        return $renta;
    }

    public static function show($id)
    {
        $tabla=$html='';
        $compra=ContratacionDirecta::find($id);
        $tabla.='';
        if($compra->estado==1):
        $tabla.='<button class="btn btn-primary agregar_sol" type="button">Agregar</button>
        <button style="display:none" class="btn btn-primary add_material" type="button">Material</button>
        <button style="display:none" class="btn btn-primary add_unidad" type="button">Unidad medida</button>
        <br><br>';
        endif;
        $tabla.='<table class="table tabla_solicitud">
          <thead>
            <tr>
              <th>N°</th>
              <th>Descripción</th>
              <th>Unidad de medida</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Total</th>';
              if($compra->estado==1):
              $tabla.='<th>Acción</th>';
              endif;
            $tabla.='</tr>
          </thead>
          <tbody>';
        foreach($compra->materiales  as $i=>$m){
            $tabla.='<tr>
            <td>'.($i+1).'</td>
            <td>'.$m->material->nombre.'</td>
            <td>'.$m->medida->nombre_medida.'</td>
            <td>
                <span class="visible'.$i.'">'.$m->cantidad.'</span>
                <input style="display:none;" type="number" value="'.$m->cantidad.'" class="form-control e_canti'.$i.' invisible'.$i.'">
            </td>
            <td class="text-right">
                <span class="visible'.$i.'">$'.number_format($m->precio,2).'</span>
                <input style="display:none;" type="number" value="'.$m->precio.'" class="form-control e_precio'.$i.' invisible'.$i.'">
            </td>
            <td class="text-right">$'.number_format($m->precio*$m->cantidad,2).'</td>';
            if($compra->estado==1):
            $tabla.='<td>
                <button data-id="'.$m->id.'" data-fila="'.$i.'" class="btn btn-warning edit_orden visible'.$i.'" type="button"><i class="fa fa-edit"></i></button>
                <button style="display:none;" type="button" data-id="'.$m->id.'" data-fila="'.$i.'" id="put_edit" class="btn btn-success invisible'.$i.'">
            <i class="fa fa-check"></i>
            </button>
            <button style="display:none;" type="button" data-id="'.$m->id.'" data-fila="'.$i.'"  class="btn btn-danger can_edit_r invisible'.$i.'">
            <i class="fa fa-minus-circle"></i>
            </button>
            </td>';
            endif;
            $tabla.='</tr>';
        }
        $tabla.='</tbody>
        </table>';

        $html.='<div>';
        if($compra->estado==1):
        $html.='<label for="" class="label-primary col-xs-12">Pendiente asignar proveedor</label>
        <button data-id="{{$compra->id}}" class="btn btn-primary proveedor" type="button">Seleccionar proveedor</button>';
        elseif($compra->estado==2):
        elseif($compra->estado==3):
        $html.='<button class="btn btn-primary orden" type="button" data-id="'.$compra->id.'">Orden de compra</button><br><br>
        <label for="" class="label-info col-xs-12">Emitir orden de compra</label>';
        elseif($compra->estado==4):
        $html.='<label for="" class="label-success col-xs-12">Orden de compra emitida</label><br><br>
        <a href="../reportesuaci/ordencompra2/'.$compra->orden->id.'" target="_blank" class="btn btn-primary vista_previa"><i class="fa fa-print"></i></a>
        <button class="btn btn-primary fin_compra" type="button" data-id="'.$compra->id.'" title="Finalizar proceso de compra"><i class="fa fa-check"></i></button>';
        elseif($compra->estado==5):
          $html.='<label for="" class="label-success col-xs-12">Espera de desembolso</label><br><br>
          <a href="../reportesuaci/ordencompra2/'.$compra->orden->id.'" target="_blank" class="btn btn-primary vista_previa"><i class="fa fa-print"></i></a>';         
      endif;
          $html.='<div class="col-sm-12">
              <span style="font-weight: normal;">Código:</span>
            </div>
            <div class="col-sm-12">
              <span><b>'.$compra->codigo.'</b></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin-top: 3px; margin-bottom: 3px;">

            <div class="col-sm-12">
              <span style="font-weight: normal;">Número del proceso:</span>
            </div>
            <div class="col-sm-12">
              <span><b>'.$compra->numero_proceso.'</b></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin-top: 3px; margin-bottom: 3px;">

            <div class="col-sm-12">
              <span style="font-weight: normal;">Nombre del proceso:</span>
            </div>
            <div class="col-sm-12">
              <span><b>'.$compra->nombre.'</b></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin-top: 3px; margin-bottom: 3px;">

            <div class="col-sm-12">
              <span style="font-weight: normal;">Monto:</span>
            </div>
            <div class="col-sm-12">
              <span><b>$'.number_format(ContratacionDirecta::total($compra->id),2).'</b></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin-top: 3px; margin-bottom: 3px;">

            <div class="col-sm-12">
              <span style="font-weight: normal;">Renta:</span>
            </div>
            <div class="col-sm-12">
              <span><b>$'.number_format(ContratacionDirecta::renta($compra->id),2).'</b></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin-top: 3px; margin-bottom: 3px;">

            <div class="col-sm-12">
              <span style="font-weight: normal;">Total:</span>
            </div>
            <div class="col-sm-12">
              <span><b>$'.number_format(ContratacionDirecta::total($compra->id)-ContratacionDirecta::renta($compra->id),2).'</b></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin-top: 3px; margin-bottom: 3px;">

            <div class="col-sm-12">
              <span style="font-weight: normal;">Declaratoria de emergencia:</span>
            </div>
            <div class="col-sm-12">
              <span><b>'. $compra->emergencia->numero_acuerdo.'</b></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin-top: 3px; margin-bottom: 3px;">

            <div class="col-sm-12">
              <span style="font-weight: normal;">Motivo de la emergencia:</span>
            </div>
            <div class="col-sm-12">
              <span><b>'. $compra->emergencia->detalle.'</b></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin-top: 3px; margin-bottom: 3px;">
            <div class="col-sm-12">
              <span style="font-weight: normal;">Cuenta:</span>
            </div>
            <div class="col-sm-12">
              <span><b>'. $compra->cuenta->nombre.'</b></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin-top: 3px; margin-bottom: 3px;">
            <div class="col-sm-12">
              <span style="font-weight: normal;">Proveedor aceptado:</span>
            </div>
            <div class="col-sm-12">
              <span><b>'. $compra->proveedor->nombre.'</b></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin-top: 3px; margin-bottom: 3px;">
            <br>';
            if($compra->estado==1):
            $html.='<a href="javascript:void(0)" class="btn btn-warning editar" data-id="'.$compra->id.'"><i class="fa fa-edit"></i></a>';
            endif;
            $html.='</div>';

        return array(1,"exito",$tabla,$html);
    }
}
