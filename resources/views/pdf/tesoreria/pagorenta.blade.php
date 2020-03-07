@extends('pdf.plantilla')
@section('reporte')
@include('pdf.tesoreria.cabecera')
@include('pdf.tesoreria.pie')
<div id="content">
	<table class="table table-hover" width="100%" rules="all">
		<td>
			Contribuyente: {{$pagorentas->nombre}}
		</td>
	</table>
</div>
@endsection