@extends('layouts.app')

@section('migasdepan')
<h1>
	Categorías de trabajo
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/categoriatrabajos') }}"><i class="fa fa-dashboard"></i>Categoría de trabajos</a></li>
	<li class="active">Listado de categorías</li>
</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box">
		<div class="box-header">
			<h3 class="box-tittle">Listado</h3>
			<a href="{{ url('/categoriatrabajos/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span>Agregar</a>
			<a href="{{ url('/categoriatrabajos?estado=1') }}" class="btn btn-primary">Activos</a>
			<a href="{{ url('categoriatrabajos?estado=2') }}" class="btn btn-primary">Papelera</a>
		</div>

		<div class="box-body table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example2">
				<thead>
					<th>Categoría de trabajo</th>
					<th>Acción</th>
					<?php $contador = 0 ?>
				</thead>
			<tbody>
				@foreach($categoriatrabajos as $categoriatrabajo)
				<tr>
					<?php $contador++ ?>
					<td>{{ $categoriatrabajo->nombre_categoria }}</td>
					<td>
						@if($categoriatrabajo->estado == 1)
						{{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
						<a href="{{ url('categoriatrabajos/'.$categoriatrabajo->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
						<a href="{{ url('categoriatrabajos/'.$categoriatrabajo->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
						<button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$categoriatrabajo->id.",'categoriatrabajos')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@else
						{{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
						<button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$categoriatrabajo->id.",'categoriatrabajos')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
			</table>

			<div class="pull-right">
				
			</div>
		</div>
	</div>
	</div>
</div>
@endsection