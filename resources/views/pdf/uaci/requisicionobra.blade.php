@extends('pdf.plantilla')
@section('reporte')
@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
<div class="container">
	<div class="row">
		<div class="col-md-11">
			<div class="panel panel-primary">
				<div class="panel-body">
					<hr style="color:blue">
					<hr style="color:red">
					<br>
					<table align="center" width="70%" border="2" rules="all" cellspacing="7px">
						<td>
							<center>{{$tipo}}</center>
						</td>
					</table>
					<br>
					<table width="100%" rules="" cellspacing="7px">
						<tbody>
							<tr>
								<td>
									<b>UNIDAD SOLICITANTE:</b> {{$requisicion->user->roleuser->role->description}}
									<p></p>
									<b>RESPONSABLE:</b> {{$requisicion->user->empleado->nombre}}
								</td>
								<td>
									<b>FECHA:</b> {{ fechaCastellano($requisicion->created_at) }}
									<p></p>
									<b>FIRMA:</b> 
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
						<tbody>
							@foreach($requisicion->requisiciondetalle as $index => $detalle)
							<tr>
								<td>
									{{$index+1}}
								</td>
								<td>
									{{$detalle->cantidad}}
								</td>
								<td>
									{{$detalle->descripcion}}
								</td>
								<td>
									{{$detalle->unidad_medida}}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>

					<p></p>
					OBSERVACIONES: {{$requisicion->observaciones}}

					<p></p>

					<table width="100%" cellspacing="30px">
						<tr>
							<td>
								AUTORIZA:
							</td>
							<td>
								RECIBE:
							</td>
						</tr>
						<tr>
							<td>	
								F.____________________
								<p></p>
								ALCALDE MUNICIPAL
							</td>
							<td>
								F.____________________
								<p></p>
								JEFE DE UACI
							</td>
						</tr>
					</table>

									
				</div>
			</div>
		</div>
	</div>
</div>