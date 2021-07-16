@extends('layouts.app')

@section('migasdepan')
    <h1>

        <p>
            <small>Modificar Préstamo de <b>{{ $prestamo->empleado->nombre }}</b></small>
        </p>
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
                <div class="panel-heading">Editar Préstamo</div>
                <div class="panel-body">
                    <p></p>
                    {{ Form::model($prestamo, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('prestamos.update', $prestamo->id))) }}
                    @include('prestamos.formulario')
                    <div class="form-group">
                        <p></p>
                        <div class="col-md-6 col-md-offset-5">
                            <button type="submit" class="btn btn-success">
                                <span class=""></span>    Guardar
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
