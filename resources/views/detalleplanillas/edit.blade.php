@extends('layouts.app')

@section('migasdepan')
<h1>
        Editar detalle <small>{{ $detalle->empleado->nombre }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>        
        <li><a href="{{ url('/detalleplanillas') }}"><i class="fa fa-dashboard"></i>Detalles de planilla</a></li>
        <li class="active">Edición</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Datos de detalle de planilla</div>
                <div class="panel-body">
                    {{ Form::model($detalle, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('detalleplanillas.update', $detalle->id))) }}
                        @include('detalleplanillas.formulario')
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk"></span>    Editar
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
