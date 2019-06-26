@extends('layouts.app')

@section('migasdepan')
<h1>
        Empleado: {{ $empleado->nombre }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/empleados') }}"><i class="fa fa-dashboard"></i> Empleados</a></li>
        <li class="active">Edición</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">     
        <div class="panel-heading">Editar empleados</div>  
            <div class="panel-body">
                {{ Form::model($empleado, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('empleados.update', $empleado->id))) }} 
                 @include('empleados.formulario')
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <span class="glyphicon glyphicon-floppy-disk"></span>    Editar
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
