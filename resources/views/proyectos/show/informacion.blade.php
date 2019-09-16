<div class="col-sm-12">
	<span>Nombre del proyecto:</span>
</div>
<div class="col-sm-12">
	<span><b>{{$proyecto->nombre}}</b></span>
</div>
<div class="clearfix"></div>
<hr style="margin-top: 3px; margin-bottom: 3px;">
<div class="col-sm-12">
	<span>Justificación:</span>
</div>
<div class="col-sm-12">
	<span><b>{{$proyecto->motivo}}</b></span>
</div>
<div class="clearfix"></div>
<hr style="margin-top: 3px; margin-bottom: 3px;">
<div class="col-sm-12">
	<span>Dirección donde se ejecutará:</span>
</div>
<div class="col-sm-12">
	<span><b>{{$proyecto->direccion}}</b></span>
</div>
<div class="clearfix"></div>
<hr style="margin-top: 3px; margin-bottom: 3px;">
<div class="col-sm-12">
	<span>Avance del proyecto:</span>
</div>
<div class="col-sm-12 progress progress-striped active">
	<div class="progress-bar progress-bar-success" role="progressbar"
			aria-valuenow="{{$proyecto->indicadores_completado->sum('porcentaje')}}" aria-valuemin="0" aria-valuemax="100"
		style="width: {{$proyecto->indicadores_completado->sum('porcentaje')}}%">
		<span class="">{{$proyecto->indicadores_completado->sum('porcentaje')}}% completado</span>
	</div>
</div>
<div class="clearfix"></div>
<hr style="margin-top: 3px; margin-bottom: 3px;">
<div class="col-sm-12">
	<span>Origen de los fondos:</span>
</div>
@foreach ($proyecto->fondo as $fondo)
		<div class="col-sm-7">
			<span><b>&nbsp;&nbsp;{{$fondo->fondocat->categoria}}</b></span>
		</div>
		<div class="col-sm-5">
			<span class="label label-primary col-sm-12">
				${{number_format($fondo->monto,2)}}
			</span>
		</div>
@endforeach
<div class="col-sm-7">
	<span><b>&nbsp;&nbsp;Total</b></span>
</div>
<div class="col-sm-5">
	<span class="label label-success col-sm-12">
		${{number_format($proyecto->monto,2)}}
	</span>
</div>
<div class="clearfix"></div>
<hr style="margin-top: 3px; margin-bottom: 3px;">
<div class="col-sm-12">
	<span>Fecha de inicio:</span>
</div>
<div class="col-sm-12">
	<span><b>{{$proyecto->fecha_inicio->format('l d')}} de {{$proyecto->fecha_inicio->format('F Y')}}</b></span>
</div>
<div class="clearfix"></div>
<hr style="margin-top: 3px; margin-bottom: 3px;">
<div class="col-sm-12">
	<span>Fecha de finalización:</span>
</div>
<div class="col-sm-12">
	<span><b>{{$proyecto->fecha_fin->format('l d')}} de {{$proyecto->fecha_fin->format('F Y')}}</b></span>
</div>
<div class="clearfix"></div>
<hr style="margin-top: 3px; margin-bottom: 3px;">
<div class="col-sm-7">
	<span>Monto de Desarrollo</span>
</div>
<div class="col-sm-5">
	<span class="label label-primary col-sm-12">
		${{number_format($proyecto->monto_desarrollo,2)}}
	</span>
</div>
<div class="clearfix"></div>
<hr style="margin-top: 3px; margin-bottom: 3px;">
<div class="col-sm-7">
	<span>Beneficiarios</span>
</div>
<div class="col-sm-5">
	<span class="label label-primary col-sm-12">
		{{$proyecto->beneficiarios}}
	</span>
</div>