@extends('layouts.app')

@section('migasdepan')
<h1>
        Detalles de planilla
        <small>Control de Detalles</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/detalleplanillas') }}"><i class="fa fa-address-card"></i>Detalles de Planilla</a></li>
        <li class="active">Registro</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de Detalles</div>
                <div class="panel-body">
                    {{ Form::open(['route' =>'detalleplanillas.store','method' =>'POST','autocomplete'=>'off','class' => 'form-horizontal']) }}
                        @include('errors.validacion')
                        @include('detalleplanillas.formulario')
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                    <span class="glyphicon glyphicon-floppy-disk"></span>Registrar
                                </button>
                            </div>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
