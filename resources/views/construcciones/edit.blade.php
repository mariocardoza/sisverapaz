@extends('layouts.app')

@section('migasdepan')
<h1>
      Editar información: <small> {{ $construccion->contribuyente_id }} </small>
</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/construcciones') }}"><i class="fa fa-industry"></i> Construcciones</a></li>
        <li class="active">Edición</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                {{ Form::model($construccion, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('construcciones.update', $construccion->id))) }}
                 @include('construcciones.formulario')
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-success">
                                <span class=""></span> Guardar
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
