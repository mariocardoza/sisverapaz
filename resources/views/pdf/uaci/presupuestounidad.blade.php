@extends('pdf.plantilla')
@section('reporte')
@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
<div id="content">
	<table class="table table-hover" width="100%" rules="all">
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
			@foreach($presupuestounidades as $presupuestounidad)
			<tr>
				<?php $correlativo++?>
				<td>{{ $presupuestounidad->material }}</td>
				
				
				<td>{{ $presupuestounidad->cantidad }}</td>
				<td>{{ $presupuestounidad->preciou }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection