@extends('pdf.plantilla')
@section('reporte')
@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
<div id="content">
	<table class="table table-bordered" width="100%" >
		<thead>
			<tr>
				<th>N°</th>
				<th>Nombre</th>
				<th>Unidad de medida</th>
				<th>Cantidad</th>
				<th>Precio</th>
				<?php $correlativo=0?>
			</tr>
		</thead>
		<tbody>
			@foreach($presupuesto->presupuestodetalle as $correlativo => $presupuestounidad)
			<tr>
				<td>{{$correlativo+1}}</td>
				<td>{{ $presupuestounidad->material->nombre }}</td>
				
				<td>{{$presupuestounidad->material->unidadmedida->nombre_medida}}</td>
				<td>{{ $presupuestounidad->cantidad }}</td>
				<td>{{ $presupuestounidad->precio }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection