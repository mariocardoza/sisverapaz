	<h4><i class="glyphicon glyphicon-briefcase"></i></h4>
		
	<table class="table table-striped table-hover">
		<thead>
			<th>Descripción</th>
			<th>Unidad de medida</th>
			<th>Cantidad</th>
			<th>Precio Unitario</th>
			<th>Subtotal</th>
			<th>Opciones</th>
			<?php $contador=0; $total=0.0 ?>
		</thead>
		<tbody>
			@php
				$categ=array();
			@endphp
			@foreach($proyecto->presupuesto->presupuestodetalle as $detalle)
			@php
				if(!in_array($detalle->material->categoria->nombre_categoria,$categ)){
					$categ[]=$detalle->material->categoria->nombre_categoria;
				}
				
			@endphp
			@endforeach
			@foreach($categ as $c)
			<tr><th colspan='6' class="text-center">{{$c}}</th></tr>
			@foreach($proyecto->presupuesto->presupuestodetalle as $detalle)
			@if($c==$detalle->material->categoria->nombre_categoria)
			<?php 
			?>
				<tr>
					<?php $contador++;
						$total=$total+$detalle->cantidad*$detalle->preciou;?>
					<td>{{$detalle->material->nombre}}</td>
					<td>{{$detalle->material->unidadmedida->nombre_medida}}</td>
					<td>{{$detalle->cantidad}}</td>
					<td>${{number_format($detalle->preciou,2)}}</td>
					<td>${{number_format($detalle->cantidad*$detalle->preciou,2)}}</td>
					<td>
						
						<div class="btn-group">
							<a class="btn btn-warning btn-sm" href="javascript:void(0)"><span class="glyphicon glyphicon-edit"></span></a>
							<button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></button>
							</div>
						
					</td>
				</tr>
				@endif
			@endforeach
			@endforeach
				<tr>
					<td colspan="5" class="text-center">TOTAL</td>
					<td colspan="2"><b>{{'$'.number_format($total,2)}}</b></td>
				</tr>
		</tbody>
	</table>
