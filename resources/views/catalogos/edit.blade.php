@extends('layouts.app')

@section('migasdepan')
<h1>
	Catálogo: <small>{{ $catalogo->nombre }}</small>
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
	<li><a href="{{ url('catalogos') }}"><i class="fa fa-dashboard"></i> Catálogos</a></li>
	<li class="active">Edición</li>
</ol>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-body">
				{{ Form::model($catalogo, array('method' => 'put', 'class' => 'form-horizontal', 'route' => array('catalogos.update', $catalogo->id))) }}
				@include('catalogos.formulario')
				<div class="form-group">
					<div class="col-md-6 col-md-offset-2">
						<button type="submit" class="btn btn-primary">
							<span class="glyphicon glyphicon-floppy-disk"></span> Editar
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
@endsection