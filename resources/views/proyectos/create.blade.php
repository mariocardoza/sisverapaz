@extends('layouts.app')

@section('migasdepan')
<h1>
        Proyecto
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Registro</li>
      </ol>
@endsection

@section('content')
<div class="container" id="app">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de proyectos</div>
                <div class="panel-body">
                    {{ Form::open(['action'=> 'ProyectoController@store', 'class' => 'form-horizontal']) }}
                    @include('errors.validacion')
                    <input type="hidden" name="contador_fondos" id="contador_fondos">
                    <input type="hidden" name="contador_org" id="contador_org">
                    @include('proyectos.formulario')

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="button" id="btnsubmit" class="btn btn-success">
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
@section('scripts')
{!! Html::script('js/proyecto.js') !!}
@endsection
