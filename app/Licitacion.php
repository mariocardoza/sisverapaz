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
        if($proyecto->licitacionbase->count() == 0 && $proyecto->estado>=2):
            $html.='<center>
            <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
            <span>Agregue las bases de licitación para el proyecto</span><br>';
            if($proyecto->estado<=4):
            $html.='<button class="btn btn-primary" type="button" id="subir_bases">Subir</button>';
            endif;
            $html.='</center>';
            else:
                $html.='
                <div class="nav-tabs-custom" style=" ">
            <ul class="nav nav-tabs hidden-print">
              <li class="active"><a href="#bases" data-toggle="tab">Bases de licitación</a></li>';
              if($proyecto->estado>2):
              $html.='<li><a href="#ofertas" data-toggle="tab">Ofertas</a></li>';
              endif;
              
              $html.='</ul>
            <div class="tab-content">
              <div class=" tab-pane" id="ofertas">';
              if($proyecto->estado<=4):
                $html.='<button class="btn btn-primary hidden-print pull-right" type="button" id="add_oferta">Agregar</button><br>';  
              endif;
                $html.='<div class="col-md-12" style="max-height: 580px; overflow-y: scroll; overflow-y: auto;">
                <table class="table" id="estatabla">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Proveedor</th>
                        <th>Documento</th>
                        <th>Fecha guardado</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';
                    foreach($proyecto->licitacion as $i =>$e):
                        $html.='
                            <tr>
                            <td>'.($i+1).'</td>
                            <td>';
                            if($proyecto->estado<7):
                            $html.='<input data-id="'.$e->id.'" name="liciti" id="ofertita" data-proyecto="'.$e->proyecto->id.'" type="radio"> '.$e->proveedor->nombre.'';
                            else:
                            $html.=$e->proveedor->nombre;
                            endif;
                            $html.='</td>
                            <td>'.$e->archivo.'</td>
                            <td>'.$e->created_at->format("d/m/Y H:i:s a").'</td>';
                            if($e->estado==0):
                            $html.='<td><label class="label-primary col-md-12">Sin aceptar</label></td>';
                            elseif($e->estado==1):
                            $html.='<td><label class="label-success col-md-12">Aceptada</label></td>';
                            else:
                            $html.='<td><label class="label-danger col-md-12">Rechazada</label></td>';    
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
                
              </div>
              <!-- /.tab-pane -->
              <div class="active tab-pane" id="bases">';
              if($proyecto->estado>=2 && $proyecto->estado <=4):
                $html.='<button class="btn btn-primary pull-right" id="subir_bases" type="button">Subir</button>';
                endif;
                    $html.='<table class="table">
                        <thead>
                            <tr>
                                <th>Archivo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach($proyecto->licitacionbase as $b):
                                $html.='<tr>
                                    <td>'.$b->archivo.'</td>
                                    <td>
                                        <a target="_blank" class="btn btn-success" href="../proyectos/bajarbase/'.$b->archivo.'"><i class="fa fa-download"></i></a>
                                    <td>
                                </tr>';
                            endforeach;
                        $html.='</tbody>
                    </table>
              </div>
              <!-- /.tab-pane -->
    
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>';
            endif;
        return array(1,"exito",$html);
    }
}
