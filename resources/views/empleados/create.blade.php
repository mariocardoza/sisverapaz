@extends('layouts.app')

@section('migasdepan')
<h1>
        Empleado
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/empleados') }}"><i class="fa fa-dashboard"></i> Empleados</a></li>
        <li class="active">Registro</li>      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de empleados</div>
                <div class="panel-body">
                    {{ Form::open(['action'=> 'EmpleadoController@store', 'class' => 'form-horizontal','id'=>'empleado']) }}
                    @include('errors.validacion')
                    @include('empleados.formulario')

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk"> Registrar</span>
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
