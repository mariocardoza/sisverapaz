@extends('layouts.app')

@section('migasdepan')
<h1>
	Catálogos
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/catalogos') }}"><i class="fa fa-dashboard"></i>Catálogos</a></li>
	<li class="active">Listado de catálogos</li>
</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box">
		<div class="box-header btn-group">
			<h3 class="box-tittle">Listado</h3>
			<a href="{{ url('/catalogos/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span>Agregar</a>
			<a href="javascript:void(0)" class="btn btn-primary">Registrar categoría</a>
		</div>

		<div class="box-body table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example2">
				<thead>
					<th>Nombre de catálogo</th>
					<th>Unidad de medida</th>
					<th>Categoría</th>
					<th>Acción</th>
					<?php $contador = 0 ?>
				</thead>
			<tbody>
				@foreach($catalogos as $catalogo)
				<tr>
					<?php $contador++ ?>
					<td>{{ $catalogo->nombre }}</td>
					<td>{{ $catalogo->unidad_medida }}</td>
					<td>{{ $catalogo->categoria->nombre_categoria }}</td>
					<td>
						@if($catalogo->estado == 1)
						{{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
						<a href="{{ url('catalogos/'.$catalogo->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
						<a href="{{ url('catalogos/'.$catalogo->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
						<button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$catalogo->id.",'catalogos')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@else
						{{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
						<button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$catalogo->id.",'catalogos')" }}><span class="glyphicon glyphicon-trash"></span></button>
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