@extends('pdf.plantilla')

@include('pdf.uaci.cabecera')
@section('reporte')
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $pdf->text(652, 580, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
        ');
    }

</script>
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
				<th>Cantidad</th>
				<th>Unidad/m</th>
				<th>Precio</th>
				<th>Ene</th>
				<th>Feb</th>
				<th>Mar</th>
				<th>Abr</th>
				<th>May</th>
				<th>Jun</th>
				<th>Jul</th>
				<th>Ago</th>
				<th>Sep</th>
				<th>Oct</th>
				<th>Nov</th>
				<th>Dic</th>
				<?php $correlativo=0?>
			</tr>
		</thead>
		<tbody>
			
				@foreach($presupuesto->presupuestodetalle as $correlativo => $presupuestounidad)
				
				<tr>
					<td>{{$correlativo+1}}</td>
					<td>{{ $presupuestounidad->material->nombre }}</td>
					<td>{{ $presupuestounidad->cantidad }}</td>
					<td>{{$presupuestounidad->unidadmedida->nombre_medida}}</td>
					<td class="text-right">${{ number_format($presupuestounidad->material->precio_estimado,2) }}</td>
					<td>{{$presupuestounidad->enero}}</td>
					<td>{{$presupuestounidad->febrero}}</td>
					<td>{{$presupuestounidad->marzo}}</td>
					<td>{{$presupuestounidad->abril}}</td>
					<td>{{$presupuestounidad->mayo}}</td>
					<td>{{$presupuestounidad->junio}}</td>
					<td>{{$presupuestounidad->julio}}</td>
					<td>{{$presupuestounidad->agosto}}</td>
					<td>{{$presupuestounidad->septiembre}}</td>
					<td>{{$presupuestounidad->octubre}}</td>
					<td>{{$presupuestounidad->noviembre}}</td>
					<td>{{$presupuestounidad->diciembre}}</td>
				</tr>
			
			@endforeach
		</tbody>

	</table>
</div>
@endsection