@extends('layouts.app')

@section('migasdepan')
<h1>
	Materiales
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/catalogos') }}"><i class="fa fa-dashboard"></i>Materiales</a></li>
	<li class="active">Listado de materiales</li>
</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box">
		<div class="box-header btn-group">
			<h3 class="box-tittle"></h3>
			<a id="create" href="javascript:void(0)" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span>Agregar</a>
			<a href="javascript:void(0)" id="modal_categoria" class="btn btn-primary">Registrar categoría</a>
			<a href="javascript:void(0)" id="agregar_medida" class="btn btn-primary">Registrar unidad de medida</a>
		</div>

		<div class="box-body table-responsive">
			<table class="table table-striped table-hover" id="example2">
				<thead>
					<th>Nombre de catálogo</th>
					<th>Unidad de medida</th>
					<th>Categoría</th>
					<th>Acción</th>
					<?php $contador = 0 ?>
				</thead>
			<tbody>
				@foreach($materiales as $material)
				<tr>
					<?php $contador++ ?>
					<td>{{ $material->nombre }}</td>
					<td>{{ $material->unidadmedida->nombre_medida }}</td>
					<td>{{ $material->categoria->nombre_categoria }}</td>
					<td>
						@if($material->estado == 1)
						{{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
						<a href="{{ url('materiales/'.$material->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
						<button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$material->id.",'materiales')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@else
						{{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
						<button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$material->id.",'materiales')" }}><span class="glyphicon glyphicon-trash"></span></button>
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
	@include('materiales.modales')
</div>
@endsection
@section('scripts')
{!! Html::script('js/materiales.js?cod='.date('Yidisus')) !!}
@endsection