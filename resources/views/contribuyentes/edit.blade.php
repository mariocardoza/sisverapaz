@extends('layouts.app')

@section('migasdepan')
<h1>
        Usuarios
        <small>Modificar proveedor {{ $contribuyente->nombre }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/contribuyentes') }}"><i class="fa fa-dashboard"></i> Usuarios</a></li>
        <li class="active">Edición</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Edicion de Proveedor</div>
                <div class="panel-body">
                    {{ Form::model($contribuyente, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('contribuyentes.update', $contribuyente->id))) }} 
                    {{-- <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}"> --}}

                        @include('contribuyentes.formulario')

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
