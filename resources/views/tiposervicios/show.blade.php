@extends('layouts.app')

@section('migasdepan')
<h1>
	<small>Ver Servicio<b> {{$tiposervicio->tiposervicio_id}} </b></small>
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/tiposervicios') }}"><i class="fa fa-dashboard"></i> Servicios</a></li>
	<li class="active">Ver</li>
</ol>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-11">
			<div class="panel panel-primary">
				<div class="panel-heading">Servicios registrados</div>
				<div class="panel-body">

					<div class="form-group {{ $errors->has('monto') ? ' has-error ' : '' }}">
						<label for="monto" class="col-md-4 control-label">Tipo de servicio</label>
						<label for="nombre" class="col-md-4 control-label">{{$tiposervicio->nombre}}</label><br>
					</div>

					 {{Form::open(['route' => ['tiposervicios.destroy', $tiposervicio->id], 'method' => 'DELETE', 'class' => 'form-horizontal'])}}
					 <a href="{{ url('/tiposervicios/'.$tiposervicio->id.'/edit') }}" class="btn btn-warning"> <span class="glyphicon glyphicon-text-size"></span> Editar</a> |
					 <button class="btn btn-danger" type="button" onclick="return
					 swal({
					 title: 'Eliminar registro',
					 text: '¿Está seguro de eliminar el registro?',
					 type: question,
					 showCancelButton: true,
					 confirmButtonText: 'Sí, eliminar',
					 cancelButtonText: 'No, mantener',
					 confirmButtonClass: 'btn btn-danger',
					 cancelButtonClass: 'btn btn-default',
					 buttonsStyling: false
					}).then(function (){
					submit();
					swal('Hecho', 'El registro ha sido eliminado', 'success')
				}, function(dismiss){
				if(dismiss == 'cancel'){
				swal('Cancelado', 'El registro se mantiene', 'info')
			}
			});"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
			{{Form::close()}}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection