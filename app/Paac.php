<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paac extends Model
{
    protected $guarded = [];
    protected $dates = [];
    public $incrementing = false;

    public function paacdetalle()
    {
        return $this->hasMany('App\Paacdetalle');
    }

    public function paaccategoria()
    {
      return $this->belongsTo('App\PaacCategoria','paaccategoria_id');
    }

    public static function show($id){
        $paac=Paac::findorFail($id);
        $detalles = Paacdetalle::where('paac_id',$paac->id)->orderBy('id','ASC')->get();
        $html="";
        $html.='<div class="panel panel-primary">
        <div class="panel-heading">'.$paac->paaccategoria->nombre.'</div>
        <div class="panel-body">';
        if($paac->estado==1):
          $html.='<a href="javascript:void(0)" id="registrar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar elementos</a>
        <br><br>';
        endif;
        $html.='<table class="table" >
          <tr>
            <td>Año de ejecución</td>
            <th>'.$paac->anio.'</th>
          </tr>
          <tr>
            <td>Plan</td>
            <th>'.$paac->paaccategoria->nombre.'</th>
          </tr>
          <tr>
            <td>Monto</td>
            <th>$'.number_format($paac->total,2).'</th>
          </tr>
        </table>
          <div style="overflow-x:auto;">
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
                $total=0.0;
                $subto=0.0;
                
                $html.='<tr>
                  <th>Obra, bien o servicio</th>
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
                  <th>Diciembre</th>
                  <th>Total</th>';
                  if($paac->estado==1):
                  $html.='<th>Acción</th>';
                  endif;
                $html.='</tr>
              </thead>
              <tbody>';
                foreach($detalles as $detalle):
                  
                  $subto=$detalle->enero+$detalle->febrero+$detalle->marzo+$detalle->abril+$detalle->mayo+
                  $detalle->junio+$detalle->julio+$detalle->agosto+$detalle->septiembre+$detalle->octubre+
                  $detalle->noviembre+$detalle->diciembre;
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
                  $total=$total+$subto;
                  
                $html.='<tr>
                  <td>'.$detalle->obra.'</td>
                  <td>$'.number_format($detalle->enero,2).'</td>
                  <td>$'.number_format($detalle->febrero,2).'</td>
                  <td>$'.number_format($detalle->marzo,2).'</td>
                  <td>$'.number_format($detalle->abril,2).'</td>
                  <td>$'.number_format($detalle->mayo,2).'</td>
                  <td>$'.number_format($detalle->junio,2).'</td>
                  <td>$'.number_format($detalle->julio,2).'</td>
                  <td>$'.number_format($detalle->agosto,2).'</td>
                  <td>$'.number_format($detalle->septiembre,2).'</td>
                  <td>$'.number_format($detalle->octubre,2).'</td>
                  <td>$'.number_format($detalle->noviembre,2).'</td>
                  <td>$'.number_format($detalle->diciembre,2).'</td>
                  <td>$'.number_format($subto,2).'</td>';
                  if($paac->estado==1):
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
                    <th>Totales</th>
                    <th>$'.number_format($enero,2).'</th>
                    <th>$'.number_format($febrero,2).'</th>
                    <th>$'.number_format($marzo,2).'</th>
                    <th>$'.number_format($abril,2).'</th>
                    <th>$'.number_format($mayo,2).'</th>
                    <th>$'.number_format($junio,2).'</th>
                    <th>$'.number_format($julio,2).'</th>
                    <th>$'.number_format($agosto,2).'</th>
                    <th>$'.number_format($septiembre,2).'</th>
                    <th>$'.number_format($octubre,2).'</th>
                    <th>$'.number_format($noviembre,2).'</th>
                    <th>$'.number_format($diciembre,2).'</th>
                    <th>$'.number_format($total,2).'</th>';
                    if($paac->estado==1):
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
          $paac=Paacdetalle::find($id);
        $formulario='';
        $formulario.='<form id="form_paac_editar" class="form-horizontal">
        <br>
        
        <div class="form-group">
        <label for="" class="col-md-2 control-label">Obra, Bien o Servicio</label>
        <div class="col-md-8">
            <textarea class="form-control" id="e_obra" rows="3">'.$paac->obra.'</textarea>
        </div>
      </div>
      <br><br>
      <div class="form-group">
          <div class="col-md-12">
          <label for="" class="col-md-4 control-label"><b>Montos establecidos por cada mes</b></label>
          </div>
      </div>

      <div class="form-group">
          <div class="col-md-3">
          <label for="" class="col-md-2 control-label">Enero</label>
                <input type="number" id="e_ene" value="'.$paac->enero.'" class="form-control" steps="0.00" min="0">                
                <input type="hidden" id="ideditar" value="'.$paac->id.'">                

          </div>
          <div class="col-md-3">
              <label for="" class="col-md-2 control-label">Febrero</label>
              <input type="number" id="e_feb" value="'.$paac->febrero.'" class="form-control" steps="0.00" min="0">          
        </div>
          <div class="col-md-3">
              <label for="" class="col-md-2 control-label">Marzo</label>
              <input type="number" id="e_mar" class="form-control" value="'.$paac->marzo.'" steps="0.00" min="0"> 
          </div>

          <div class="col-md-3">
              <label for="" class="col-md-2 control-label">Abril</label>
              <input type="number" id="e_abr" class="form-control" value="'.$paac->abril.'" steps="0.00" min="0"> 
          </div>
      </div>

      <div class="form-group">
          
          <div class="col-md-3">
              <label for="" class="col-md-2 control-label">Mayo</label>
              <input type="number" id="e_may" value="'.$paac->mayo.'" class="form-control" steps="0.00" min="0"> 
              </div>
          <div class="col-md-3">
              <label for="" class="col-md-2 control-label">Junio</label>
              <input type="number" id="e_jun" value="'.$paac->junio.'" class="form-control" steps="0.00" min="0"> 
              </div>
          <div class="col-md-3">
                  <label for="" class="col-md-2 control-label">Julio</label>
                  <input type="number" id="e_jul" value="'.$paac->julio.'" class="form-control" steps="0.00" min="0"> 
                  </div>
                  <div class="col-md-3">
                      <label for="" class="col-md-2 control-label">Agosto</label>
                      <input type="number" id="e_ago" value="'.$paac->agosto.'" class="form-control" steps="0.00" min="0"> 
                      </div>
      </div>

      <div class="form-group">
              <div class="col-md-3">
                      <label for="" class="col-md-2 control-label">Septiembre</label>
                      <input type="number" value="'.$paac->septiembre.'" id="e_sep" class="form-control" steps="0.00" min="0"> 
                      </div>
          <div class="col-md-3">
          <label for="" class="col-md-2 control-label">Octubre</label>
          <input type="number" id="e_oct" class="form-control" value="'.$paac->octubre.'" steps="0.00" min="0"> 
          </div>
          <div class="col-md-3">
              <label for="" class="col-md-2 control-label">Noviembre</label>
              <input type="number" id="e_nov" class="form-control" value="'.$paac->noviembre.'" steps="0.00" min="0"> 
              </div>
          <div class="col-md-3">
              <label for="" class="col-md-2 control-label">Diciembre</label>
              <input type="number" id="e_dic" class="form-control" value="'.$paac->diciembre.'" steps="0.00" min="0"> 
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

          return array(1,"exito",$formulario,$paac);
        }catch(Exception $e){
          return array(-1,"error",$e->getMessage());
        }
    }

}
