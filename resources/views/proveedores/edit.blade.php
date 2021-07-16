@extends('layouts.app')

@section('migasdepan')
<h1>
        Editar Proveedor: <small>{{ $proveedor->nombre }} </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proveedores') }}"><i class="fa fa-user-circle-o"></i> Proveedores</a></li>
        <li class="active">Editar</li>
      </ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
            <div class="panel panel-heading">Editar Proveedor</div>
            <div class="panel-body">
                {{ Form::model($proveedor, array('method' => 'put', 'class' => '' , 'route' => array('proveedores.update', $proveedor->id))) }}
                 @include('proveedores.formulario')
                 @include('errors.validacion')
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
