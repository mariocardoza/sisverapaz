<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Licitacion extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];

    public static function Buscar($nombre,$estado)
    {
        return Licitacion::nombre($nombre)->estado($estado)->orderBy('id')->paginate(10);
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

    public function proyecto()
    {
        return $this->belongsTo('App\Proyecto');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }

    public static function licitacion($id)
    {
        $proyecto=Proyecto::find($id);
        $html="";
        if($proyecto->licitacion->count() == 0):
            $html.='<center>
            <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
            <span>Agregue las ofertas de los proveedores del proyecto para visualizar la información</span><br>
            <button class="btn btn-primary" type="button" id="add_oferta">Agregar</button>
            </center>';
            else:
                $html.='
                <div class="nav-tabs-custom" style=" ">
            <ul class="nav nav-tabs hidden-print">
              <li class="active"><a href="#activity" data-toggle="tab">Ofertas</a></li>
              <!--li><a href="#timeline" data-toggle="tab">Calendario</a></li-->
              <li class="pull-right"><button class="btn btn-primary hidden-print" type="button" id="add_oferta">Agregar</button></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity" style="max-height: 580px; overflow-y: scroll; overflow-y: auto;">
                    <table class="table" id="estatabla">
                        <thead>
                            <tr>
                                <th>Proveedor</th>
                                <th>Documento</th>
                                <th>Fecha guardado</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach($proyecto->licitacion as $e):
                                $html.='
                                    <tr>
                                    <td>'.$e->proveedor->nombre.'</td>
                                    <td>'.$e->archivo.'</td>
                                    <td>'.$e->created_at->format("d/m/Y H:i:s a").'</td>';
                                    if($e->estado==0):
                                    
                                    $html.='<td><label class="label-primary col-md-12">Sin aceptar</label></td>';
                                    else:
                                    $html.='<td><label class="label-success col-md-12">Aceptada</label></td>';
                                    endif;
                                    $html.='<td>
                                    <!--button class="btn btn-info btn-sm" title="Editar" type="button"><i class="fa fa-edit"></i></button-->
                                    <button class="btn btn-danger btn-sm" id="quitar_oferta" data-id="'.$e->id.'" title="Eliminar" type="button"><i class="fa fa-remove"></i></button>
                                    <a target="_blank" class="btn btn-success btn-sm" title="Descargar" href="../proyectos/bajarlicitacion/'.$e->archivo.'"><i class="fa fa-download"></i></a>
                                    </td>
                                </tr>';
                            endforeach;
                        $html.='</tbody>
                    </table>
                
              </div>
              <!-- /.tab-pane -->
              
              <!-- /.tab-pane -->
    
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>';
            endif;
        return array(1,"exito",$html);
    }
}
