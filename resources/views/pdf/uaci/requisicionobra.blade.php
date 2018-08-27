@extends('pdf.plantilla')
@section('reporte')
@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
<div class="container">
	<div class="row">
		<div class="col-md-11">
			<div class="panel panel-primary">
				<div class="panel-body">
					<table width="100%" border="" rules="all">
						<colgroup></colgroup>
						<colgroup></colgroup>
						<tbody>
							<tr>
								<td>
									<b>UNIDAD SOLICITANTE:</b> {{$requisicion->requisiciondetalle->unidad_id}}
									<p></p>
									<b>RESPONSABLE:</b> {{requisicion->lineatrabajo}}
								</td>
								<td>
									<b>FECHA:</b> {{}}
									<p></p>
									<b>FIRMA:</b> {{}}
								</td>
							</tr>
						</tbody>
					</table>

					<p></p>
					<table width="100%" border="1" rules="all">
						<thead>
							<tr>
								<th width="5%">N° ITEM</th>
								<th width="8%">CANTIDAD SOLICITADA</th>
								<th width="50%%">DESCRIPCIÓN</th>
								<th width="15%">U/MEDIDA</th>
								@php
								$correlativo = 0;
								$total = 0.0;
								@endphp
							</tr>
						</thead>
						<tfoot>
							<p></p>
							OBSERVACIONES:
							<p></p>
							AUTORIZA:
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>