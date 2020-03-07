@extends('layouts.app')

@section('migasdepan')
<h1>
	Categorías de empleados
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/categoriaempleados') }}"><i class="fa fa-dashboard"></i>Categoría de empleados</a></li>
	<li class="active">Listado de categorías</li>
</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box">
		<div class="box-header">
			<h3 class="box-tittle">Listado</h3>
			<a href="{{ url('/categoriaempleados/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span>Agregar</a>
			<a href="{{ url('/categoriaempleados?estado=1') }}" class="btn btn-primary">Activos</a>
			<a href="{{ url('categoriaempleados?estado=2') }}" class="btn btn-primary">Papelera</a>
		</div>

		<div class="box-body table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example2">
				<thead>
					<th>Empleado</th>
					<th>Categoría</th>
					<th>Cargo</th>
					<th>Acción</th>
					<?php $contador = 0 ?>
				</thead>
			<tbody>
				@foreach($categoriaempleados as $categoriaempleado)
				<tr>
					<?php $contador++ ?>
					<td>{{ $categoriaempleado->empleado->nombre }}</td>
					<td>{{ $categoriaempleado->categoriatrabajo->nombre_categoria }}</td>
					<td>{{ $categoriaempleado->cargo->cargo }}</td>
					<td>
						@if($categoriaempleado->estado == 1)
						{{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
						<a href="{{ url('categoriaempleados/'.$categoriaempleado->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
						
						<a href="{{ url('categoriaempleados/'.$categoriaempleado->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
						<button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$categoriaempleado->id.",'categoriaempleados')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@else
						{{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
						<button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$categoriaempleado->id.",'categoriaempleados')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
			</table>
		</div>
	</div>
	</div>
</div>
@endsection