@extends('pdf.plantilla')

@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
@section('reporte')
<div id="content">
	<br>
	<table width="100%">
		<tr>
			<th><b>Unidad:</b></th>
			<td>{{$presupuesto->unidad->nombre_unidad}}</td>
		</tr>
		<tr>
			<th><b>Encargado:</b></th>
			<td>{{$presupuesto->user->empleado->nombre}}</td>
		</tr>
		<tr>
			<th><b>Año:</b></th>
			<td>{{$presupuesto->anio}}</td>
		</tr>
	</table>

	<br>
	<table class="table table-bordered table-striped" >
		<thead>
			<tr>
				<th>N°</th>
				<th>Nombre</th>
				<th>Unidad de medida</th>
				<th>Cantidad</th>
				<th>Precio</th>
				<th>Subtotal</th>
				<?php $correlativo=0?>
			</tr>
		</thead>
		<tbody>
			@php
				$categ=array();
				if(isset($presupuesto->presupuestodetalle)):
					foreach($presupuesto->presupuestodetalle as $detalle):
						if(!in_array($detalle->material->categoria->nombre_categoria,$categ)){
							$categ[]=$detalle->material->categoria->nombre_categoria;
						}
					endforeach;
				endif;
			@endphp
			@foreach($categ as $c)
				<tr><th colspan="6" class="text-center">{{$c}}</th></tr>
				@foreach($presupuesto->presupuestodetalle as $correlativo => $presupuestounidad)
				
				@if(($c==$presupuestounidad->material->categoria->nombre_categoria))
				<tr>
					<td>{{$correlativo+1}}</td>
					<td>{{ $presupuestounidad->material->nombre }}</td>
					
					<td>{{$presupuestounidad->material->unidadmedida->nombre_medida}}</td>
					<td>{{ $presupuestounidad->cantidad }}</td>
					<td class="text-right">${{ number_format($presupuestounidad->precio,2) }}</td>
					<td class="text-right">${{number_format($presupuestounidad->precio*$presupuestounidad->cantidad,2)}}</td>
				</tr>
				@endif
				@endforeach
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="5"></th>
				<th class="text-right">${{number_format(App\Presupuestounidad::total_presupuesto($presupuesto->id),2)}}</th>
			</tr>
		</tfoot>
	</table>
</div>
@endsection