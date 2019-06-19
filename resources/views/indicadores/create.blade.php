@extends('layouts.app')

@section('migasdepan')
<h1>
        Proyecto
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Indicadores</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de indicadores</div>
                <div class="panel-body">
                    {{ Form::open(['action'=> 'IndicadoresController@store', 'class' => 'form-horizontal','id' =>'form_indicadores']) }}
                    @include('errors.validacion')

                    <div class="form-group">
                        <label class="control-label col-md-4">Nombre del indicador</label>
                        <div class="col-md-6">
                            <input type="text" name="indicador" class="form-control" placeholder="Nombre del indicador">
                        </div>       
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Porcentaje</label>
                        <div class="col-md-6">
                            <input type="text" name="porcentaje" class="form-control" placeholder="Digite el porcentaje que aplica">
                        </div>       
                    </div>

                     <div class="form-group">
                        <label class="control-label col-md-4">Motivo</label>
                        <div class="col-md-6">
                            <input type="text" name="motivo" class="form-control" placeholder="Digite el motivo del indicador">
                        </div>       
                    </div>
                   
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
{!! Html::script('js/indicadores.js?cod='.date('Yidisus')) !!}
@endsection
