<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Presupuestounidad extends Model
{
    protected $guarded =[];

    public function unidad()
    {
    	return $this->belongsTo('App\Unidad');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function presupuestodetalle()
    {
        return $this->hasMany('App\Presupuestounidaddetalle');
    }

    public static function estado_ver($id)
    {
      $presupuesto=Presupuestounidad::find($id);
      $html="";
      switch ($presupuesto->estado) {
        case 1:
          $html.='<span class="col-xs-12 label-primary text-center">En espera</span>';
          break;
        case 2:
          $html.='<span class="col-xs-12 label-danger text-center">Rechazado</span>';
          break;
        case 3:
          $html.='<span class="col-xs-12 label-success text-center">Aprobado</span>';
          break;
        case 4:
          $html.='<span class="col-xs-12 label-success text-center">Completado</span>';
          break;
        default:
          $html.='<span class="col-xs-12 label-success">Default</span>';
          break;
      }
      return $html;
    }

    public static function materiales($id){
      $presu=Presupuestounidad::find($id);
        $materiales = DB::table('materiales as m')
                      ->select('m.*','c.nombre_categoria')
                      ->join('categorias as c','m.categoria_id','=','c.id')
                        ->whereNotExists(function ($query) use ($id)  {
                             $query->from('presupuestounidaddetalles')
                                ->whereRaw('presupuestounidaddetalles.material_id = m.id')
                                ->whereRaw('presupuestounidaddetalles.presupuestounidad_id ='.$id);
                            })->get();
        //$materiales=Materiales::where('estado',1)->get();
       $select='<select class="chosen" name="material_id" id="elmaterial">';
        $tabla='';
        foreach ($materiales as $key => $material) {
          $select.='<option value="'.$material->id.'">'.$material->nombre.'</option>';

          $tabla.='<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$material->nombre.'</td>
                    <td>'.$material->nombre_categoria.'</td>
                    <td><button type="button" data-nombre="'.$material->nombre.'" data-material="'.$material->id.'" class="btn btn-primary btn-sm" id="esteagrega"><i class="fa fa-check"></i></button></td>
                  </tr>';
        }
        $select.='</select>';
        return array(1,"exito",$tabla,$materiales,$select);
      }

      public static function total_presupuesto($id){
        $presupuesto=Presupuestounidad::find($id);
        $total=0.0;
        foreach($presupuesto->presupuestodetalle as $deta){
          $total=$total+($deta->precio*$deta->cantidad);
        }

        return $total;
      }

      public static function show($id){
        $p=Presupuestounidad::findorFail($id);
        $detalles = Presupuestounidaddetalle::where('presupuestounidad_id',$id)->orderBy('id','ASC')->get();
        $html="";
        $html.='<div class="panel panel-primary">
        <div class="panel-heading">Presupuesto de la unidad '.$p->unidad->nombre.'</div>
        <div class="panel-body">';
        if($p->estado==1):
          $html.='<a href="javascript:void(0)" id="registrar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar elementos</a>
        <br><br>';
        endif;
        $html.='<a href="../reportesuaci/presupuestounidad/'.$p->id.'" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i></a>';

          $html.='<div style="overflow-x:auto;">
            <table class="table table-striped" id="latabla">
              <thead>';
                $enero=0.0;
                $febrero=0.0;
                $marzo=0.0;
                $abril=0.0;
                $mayo=0.0;
                $junio=0.0;
                $julio=0.0;
                $agosto=0.0;
                $septiembre=0.0;
                $octubre=0.0;
                $noviembre=0.0;
                $diciembre=0.0;
                
                $html.='<tr>
                  <th>N°</th>
                  <th>Bien o servicio</th>
                  <th>U/M</th>
                  <th>Enero</th>
                  <th>Febrero</th>
                  <th>Marzo</th>
                  <th>Abril</th>
                  <th>Mayo</th>
                  <th>Junio</th>
                  <th>Julio</th>
                  <th>Agosto</th>
                  <th>Septiembre</th>
                  <th>Octubre</th>
                  <th>Noviembre</th>
                  <th>Diciembre</th>';
                  if($p->estado==1):
                  $html.='<th>Acción</th>';
                  endif;
                $html.='</tr>
              </thead>
              <tbody>';
                foreach($detalles as $i=> $detalle):
                  
                 
                  $enero=$enero+$detalle->enero;
                  $febrero=$febrero+$detalle->febrero;
                  $marzo=$marzo+$detalle->marzo;
                  $abril=$abril+$detalle->abril;
                  $mayo=$mayo+$detalle->mayo;
                  $junio=$junio+$detalle->junio;
                  $julio=$julio+$detalle->julio;
                  $agosto=$agosto+$detalle->agosto;
                  $septiembre=$septiembre+$detalle->septiembre;
                  $octubre=$octubre+$detalle->octubre;
                  $noviembre=$noviembre+$detalle->noviembre;
                  $diciembre=$diciembre+$detalle->diciembre;
                  
                $html.='<tr>
                  <td>'.($i+1).'</td>
                  <td>'.$detalle->material->nombre.'</td>
                  <td>'.$detalle->unidadmedida->nombre_medida.'</td>
                  <td>'.number_format($detalle->enero).'</td>
                  <td>'.number_format($detalle->febrero).'</td>
                  <td>'.number_format($detalle->marzo).'</td>
                  <td>'.number_format($detalle->abril).'</td>
                  <td>'.number_format($detalle->mayo).'</td>
                  <td>'.number_format($detalle->junio).'</td>
                  <td>'.number_format($detalle->julio).'</td>
                  <td>'.number_format($detalle->agosto).'</td>
                  <td>'.number_format($detalle->septiembre).'</td>
                  <td>'.number_format($detalle->octubre).'</td>
                  <td>'.number_format($detalle->noviembre).'</td>
                  <td>'.number_format($detalle->diciembre).'</td>';
                  if($p->estado==1):
                    $html.='<td>
                    <div class="btn-group">
                    <a href="javascript:void(0)" data-id="'.$detalle->id.'" id="eleditar" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" id="eliminar" data-id="'.$detalle->id.'"><i class="fa fa-remove"></i></a>
                  </div>
                  </td>';
                  endif;
                  $html.='</tr>';
                endforeach;
              $html.='</tbody>
              <tfoot>
                <tr>
                    <th colspan="3">Totales</th>
                    <th>'.number_format($enero).'</th>
                    <th>'.number_format($febrero).'</th>
                    <th>'.number_format($marzo).'</th>
                    <th>'.number_format($abril).'</th>
                    <th>'.number_format($mayo).'</th>
                    <th>'.number_format($junio).'</th>
                    <th>'.number_format($julio).'</th>
                    <th>'.number_format($agosto).'</th>
                    <th>'.number_format($septiembre).'</th>
                    <th>'.number_format($octubre).'</th>
                    <th>'.number_format($noviembre).'</th>
                    <th>'.number_format($diciembre).'</th>';
                    if($p->estado==1):
                      $html.='<th>Acción</th>';
                      endif;
                    $html.='</tr>
              </tfoot>
            </table>
          </div>
        </div>
    </div>';

    return array(1,"exito",$html);
    }

    public static function editar($id){
      try{
      $p=Presupuestounidaddetalle::find($id);
      $formulario='';
      $formulario.='<form id="form_presupuesto_edit" class="">
      <br>
      
      <div class="form-group">
      <label for="" class="col-md-2 control-label">Bien o Servicio</label>
      <div class="col-md-8">
          <input class="form-control" value="'.$p->material->nombre.'" id="" readonly>
      </div>
    </div>
    <br><br>
    <div class="form-group">
        <div class="col-md-12">
        <label for="" class="col-md-4 control-label"><b>Cantidades establecidas por cada mes</b></label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3">
        <label for="" class="col-md-2 control-label">Enero</label>
              <input type="number" id="e_ene" value="'.$p->enero.'" class="form-control" steps="0.00" min="0">                
              <input type="hidden" id="ideditar" value="'.$p->id.'">                

        </div>
        <div class="col-md-3">
            <label for="" class="col-md-2 control-label">Febrero</label>
            <input type="number" id="e_feb" value="'.$p->febrero.'" class="form-control" steps="0.00" min="0">          
      </div>
        <div class="col-md-3">
            <label for="" class="col-md-2 control-label">Marzo</label>
            <input type="number" id="e_mar" class="form-control" value="'.$p->marzo.'" steps="0.00" min="0"> 
        </div>

        <div class="col-md-3">
            <label for="" class="col-md-2 control-label">Abril</label>
            <input type="number" id="e_abr" class="form-control" value="'.$p->abril.'" steps="0.00" min="0"> 
        </div>
    </div>

    <div class="form-group">
        
        <div class="col-md-3">
            <label for="" class="col-md-2 control-label">Mayo</label>
            <input type="number" id="e_may" value="'.$p->mayo.'" class="form-control" steps="0.00" min="0"> 
            </div>
        <div class="col-md-3">
            <label for="" class="col-md-2 control-label">Junio</label>
            <input type="number" id="e_jun" value="'.$p->junio.'" class="form-control" steps="0.00" min="0"> 
            </div>
        <div class="col-md-3">
                <label for="" class="col-md-2 control-label">Julio</label>
                <input type="number" id="e_jul" value="'.$p->julio.'" class="form-control" steps="0.00" min="0"> 
                </div>
                <div class="col-md-3">
                    <label for="" class="col-md-2 control-label">Agosto</label>
                    <input type="number" id="e_ago" value="'.$p->agosto.'" class="form-control" steps="0.00" min="0"> 
                    </div>
    </div>

    <div class="form-group">
            <div class="col-md-3">
                    <label for="" class="col-md-2 control-label">Septiembre</label>
                    <input type="number" value="'.$p->septiembre.'" id="e_sep" class="form-control" steps="0.00" min="0"> 
                    </div>
        <div class="col-md-3">
        <label for="" class="col-md-2 control-label">Octubre</label>
        <input type="number" id="e_oct" class="form-control" value="'.$p->octubre.'" steps="0.00" min="0"> 
        </div>
        <div class="col-md-3">
            <label for="" class="col-md-2 control-label">Noviembre</label>
            <input type="number" id="e_nov" class="form-control" value="'.$p->noviembre.'" steps="0.00" min="0"> 
            </div>
        <div class="col-md-3">
            <label for="" class="col-md-2 control-label">Diciembre</label>
            <input type="number" id="e_dic" class="form-control" value="'.$p->diciembre.'" steps="0.00" min="0"> 
            </div>
    </div>


    <br>
    
    
    
    <div class="form-group">
                <center>
                    <button type="button" id="editar" class="btn btn-success">Editar</button>
                    <button class="btn btn-info" id="cancelar_editar" type="button">Cancelar</button>
                </center>

            </div>
            
      </form>';

        return array(1,"exito",$formulario,$p);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
  }
}
