@extends('layouts.app')

@section('migasdepan')
<h1>
	Materiales o Bienes
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
	<li class="active">Listado de materiales o bienes</li>
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
					<th>Tipo</th>
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
						@if($material->servicio==0)
						No es servicio
						@else
						Es servicio
						@endif
					</td>
					<td>
						@if($material->estado == 1)
						{{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
					<a href="javascript:void(0)" id="modal_edit" data-id="{{$material->id}}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
						<button title="Dar de baja" class="btn btn-danger btn-xs" type="button" onclick={{ "baja('$material->id','materiales')" }}><span class="glyphicon glyphicon-trash"></span></button>
						{{ Form::close()}}
						@else
						{{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
						<button title="Restaurar" class="btn btn-success btn-xs" type="button" onclick={{ "alta('$material->id','materiales')" }}><span class="glyphicon glyphicon-refresh"></span></button>
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
	<div id="aqui_modal"></div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/materiales.js?cod='.date('Yidisus')) !!}
@endsection