@extends('layouts.app')

@section('migasdepan')
    <h1>

        <small>Modificar Préstamo de {{ $prestamo->empleado->nombre }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/prestamos') }}"><i class="fa fa-dashboard"></i> Préstamos</a></li>
        <li class="active">Edición</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
                <div class="panel panel-primary">
                <div class="panel-heading">Edicion del préstamo</div>
                <div class="panel-body">
                    {{ Form::model($prestamo, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('prestamos.update', $prestamo->id))) }}
                    @include('prestamos.formulario')
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-floppy-disk"></span>    Modificar
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
