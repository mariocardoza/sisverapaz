<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Calendarizacion extends Model
{
	protected $guarded = [];

	protected $dates = ['inicio','fin'];

	public static function calendario($id)
	{
		$proyecto=Proyecto::find($id);
		$loseventos=[];
		$html='';
		if($proyecto->calendario->count() == 0 && ($proyecto->estado == 1 || $proyecto->estado==2)):
		$html.='<center>
		<h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
		<span>Agregue evento para la candelarización del proyectopara visualizar la información en el calendario</span><br>
		<button class="btn btn-primary" type="button" id="add_evento">Agregar</button>
		</center>';
		else:
			$html.='
			<div class="nav-tabs-custom" style=" ">
        <ul class="nav nav-tabs hidden-print">
          <li class="active"><a href="#activity" data-toggle="tab">Actividades</a></li>
		  <li><a href="#timeline" data-toggle="tab">Calendario</a></li>';
		  if($proyecto->estado == 1 || $proyecto->estado==2):
          	$html.='<li class="pull-right"><button class="btn btn-primary hidden-print" type="button" id="add_evento">Agregar</button></li>';
		  endif;
	  $html.='</ul>
        <div class="tab-content">
          <div class="active tab-pane" id="activity" style="max-height: 580px; overflow-y: scroll; overflow-y: auto;">
				<table class="table" id="calender">
					<thead>
						<tr>
							<th>Evento</th>
							<th>Inicio</th>
							<th>Fin</th>
							<th>Observaciones</th>
							<th></th>
						</tr>
					</thead>
					<tbody>';
						foreach($proyecto->calendario as $e):
							array_push($loseventos,['title'=>$e->evento,
													'start'=>$e->inicio->format("Y-m-d H:i"),
													'end'=>$e->fin->format("Y-m-d H:i")]);
							$html.='<tr>
								<td>'.$e->evento.'</td>
								<td>'.$e->inicio->format("d/m/Y H:i").'</td>
								<td>'.$e->fin->format("d/m/Y H:i").'</td>
								<td>'.$e->descripcion.'</td>
								<td>
									<button type="button" class="btn btn-danger btn-sm" id="eli_acti" data-id="'.$e->id.'"><i class="fa fa-remove"></i></button>
								</td>
							</tr>';
						endforeach;
					$html.='</tbody>
				</table>
            
          </div>
          <!-- /.tab-pane -->
		  <div class="tab-pane" id="timeline">
			<button type="button" class="btn btn-primary pull-right hidden-print" id="printcal"><i class="fa fa-print"></i></button>
			<div id="calendario"></div>
            
          </div>
          <!-- /.tab-pane -->

          
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>';
		endif;
		
		

		return array(1,"exito",$html,$loseventos);
	}
}
