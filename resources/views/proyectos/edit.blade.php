@extends('layouts.app')

@section('migasdepan')
<h1>
      Editar datos generales del proyecto:
</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Edición</li>
      </ol>
@endsection

@section('content')
<div class="container" id=app>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
                {{ Form::model($proyecto, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('proyectos.update', $proyecto->id))) }}
                @include('proyectos.formularioedit')
                @include('errors.validacion')
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk"></span>    Editar
                            </button>
                            <button type="button" class="btn btn-default" id="limpiar">Limpiar</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/proyectoe.js') !!}
@endsection
