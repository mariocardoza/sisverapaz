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
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">Editar proyecto</div>
            <div class="panel-body">
                {{ Form::model($proyecto, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('proyectos.update', $proyecto->id))) }}
                @include('proyectos.formularioedit')
                @include('errors.validacion')
                    <center>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-success">
                                    <span class="glyphicon glyphicon-floppy-disk"></span>    Editar
                                </button>
                                <button type="button" class="btn btn-default" id="limpiar">Cancelar</button>
                            </div>
                        </div>
                    </center>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
{!! Html::script('js/proyectoe.js?cod='.date('yidisus')) !!}
@endsection
