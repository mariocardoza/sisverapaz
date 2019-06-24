@foreach($proyecto->presupuesto as $presupuesto)
	<h4><i class="glyphicon glyphicon-briefcase"></i> ÍTEM {{$presupuesto->categoria->item}} {{$presupuesto->categoria->nombre_categoria}}</h4>
	<table class="table table-striped table-hover">
		<thead>
			<th>N°</th>
			<th>Descripción</th>
			<th>Unidad de medida</th>
			<th>Cantidad</th>
			<th>Precio Unitario</th>
			<th>Subtotal</th>
			<th>Opciones</th>
			<?php $contador=0; $total=0.0 ?>
		</thead>
		<tbody>
			@foreach($presupuesto->presupuestodetalle as $detalle)
				<tr>
					<?php $contador++;
						$total=$total+$detalle->cantidad*$detalle->preciou;?>
					<td>{{$contador}}</td>
					<td>{{$detalle->catalogo->nombre}}</td>
					<td>{{$detalle->catalogo->unidad_medida}}</td>
					<td>{{$detalle->cantidad}}</td>
					<td>${{number_format($detalle->preciou,2)}}</td>
					<td>${{number_format($detalle->cantidad*$detalle->preciou,2)}}</td>
					<td>
							{!! Form::open(['method' => 'DELETE', 'route' => ['presupuestodetalles.destroy', $detalle->id]]) !!}
							<div class="btn-group">
								<a class="btn btn-warning btn-xs" href="{{url('presupuestodetalles/'.$detalle->id.'/edit')}}"><span class="glyphicon glyphicon-edit"></span></a>
								<button type="submit" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
								</div>
							{{ Form::close() }}
					</td>
				</tr>
			@endforeach
				<tr>
					<td colspan="5" class="text-center">TOTAL</td>
					<td colspan="2"><b>{{'$'.number_format($total,2)}}</b></td>
				</tr>
		</tbody>
	</table>
@endforeach