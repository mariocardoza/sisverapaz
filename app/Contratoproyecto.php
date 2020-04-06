<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoProyecto extends Model
{

  protected $dates = ['created_at'];
  protected $guarded=[];
  public $incrementing = false;

    public function proyecto()
    {
      return $this->belongsTo('App\Proyecto');
    }

    public static function mostrar_contratos($id)
    {
        try{
            $contratos=ContratoProyecto::where('proyecto_id',$id)->orderBy('created_at','asc');
            $proyecto=Proyecto::find($id);
            $html='';
            if($proyecto->tipo_proyecto==1):
                if(count($proyecto->contratoproyectos) > 0):
                  $html.='
                  <button class="btn btn-primary btn-sm pull-right" id="subir_contrato" type="button">Registrar</button>
                  <table class="table" id="latabla">
                    <thead>
                      <th>N°</th>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Fecha</th>
                      <th>Acciones</th>
                    </thead>
                    <tbody>';
                      foreach($proyecto->contratoproyectos as $index => $contrato):
                        $html.='<tr>
                        <td>'.($index+1).'</td>
                        <td>'.$contrato->nombre.'</td>
                        <td>'.$contrato->descripcion.'</td>
                        <td>'.$contrato->created_at->format('d/m/Y').'</td>
                        <td>
                        <a href="javascript:void(0)" id="quitar_contrato" data-id="'.$contrato->id.'" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i></a>
                        <a href="../contratoproyectos/bajar/'.$contrato->archivo.'" id="descargar_contrato" target="_blank" data-id="'.$contrato->id.'" class="btn btn-success btn-sm"><i class="fa fa-download"></i></a>
                        </td>
                        </tr>';
                      endforeach;
                    $html.='</tbody>
                  </table>';
                else:
                  if($proyecto->estado==11):
                    $html.='<h4 class="text-yellow text-center"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                    <center><span class="text-center">El proyecto fue rechazado</span><br>
                    </center>';
                  else:
                    $html.='<h4 class="text-yellow text-center"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                    <center><span class="text-center">Aún no ha registrado ningún contrato</span><br>
                    <button class="btn btn-primary btn-sm" id="subir_contrato" type="button">Registrar</button>
                    </center>';
                  endif;
                endif;
            else:
              if($proyecto->estado<=4):
                $html.='<h4 class="text-yellow text-center"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                <center><span class="text-center">Aún no ha seleccionado a un ofertante</span><br>
                <!--button class="btn btn-primary btn-sm" id="subir_contrato" type="button">Registrar</button-->
                </center>';
              else:
                if(count($proyecto->contratoproyectos)>0):
                  $html.='
                  <button class="btn btn-primary btn-sm pull-right" id="subir_contrato" type="button">Registrar</button>
                  <table class="table" id="latabla">
                    <thead>
                      <th>N°</th>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Fecha</th>
                      <th>Acciones</th>
                    </thead>
                    <tbody>';
                      foreach($proyecto->contratoproyectos as $index => $contrato):
                        $html.='<tr>
                        <td>'.($index+1).'</td>
                        <td>'.$contrato->nombre.'</td>
                        <td>'.$contrato->descripcion.'</td>
                        <td>'.$contrato->created_at->format('d/m/Y').'</td>
                        <td>
                        <a href="javascript:void(0)" id="quitar_contrato" data-id="'.$contrato->id.'" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i></a>
                        <a href="../contratoproyectos/bajar/'.$contrato->archivo.'" id="descargar_contrato" target="_blank" data-id="'.$contrato->id.'" class="btn btn-success btn-sm"><i class="fa fa-download"></i></a>
                        </td>
                        </tr>';
                      endforeach;
                    $html.='</tbody>
                  </table>';
                else:
                  $html.='<h4 class="text-yellow text-center"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                    <center><span class="text-center">Aún no ha registrado ningún contrato</span><br>
                    <button class="btn btn-primary btn-sm" id="subir_contrato" type="button">Registrar</button>
                    </center>';
                endif;
              endif;
            endif;
            return array(1,"exito",$html);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }
}
