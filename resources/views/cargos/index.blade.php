@extends('layouts.app')

@section('migasdepan')
<h1>
	Cargos
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/cargos') }}"><i class="fa fa-dashboard"></i>Cargos</a></li>
	<li class="active">Listado de cargos</li>
</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box">
		<div class="box-header">
			<h3 class="box-tittle">Listado</h3>
			<a href="{{ url('/cargos/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span>Agregar</a>
			<a href="{{ url('/cargos?estado=1') }}" class="btn btn-primary">Activos</a>
			<a href="{{ url('cargos?estado=2') }}" class="btn btn-primary">Papelera</a>
		</div>

		<div class="box-body table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example2">
				<thead>
					<th>Cargos</th>
					<th>Acción</th>
					<?php $contador = 0 ?>
				</thead>
			<tbody>
				@foreach($cargos as $cargo)
				<tr>
					<?php $contador++ ?>
					<td>{{ $cargo->cargo }}</td>
					
					<td>
						@if($cargo->estado == 1)
						{{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
						<a href="{{ url('cargos/'.$cargo->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
						<a href="{{ url('crgoss/'.$cargo->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
						<button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$cargo->id.",'cargos')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@else
						{{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
						<button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$cargo->id.",'cargos')" }}><span class="glyphicon glyphicon-trash"></span></button>
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