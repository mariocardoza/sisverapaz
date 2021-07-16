@extends('layouts.app')

@section('migasdepan')
    <h1>
        Presupuesto
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
      <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
      <li class="active">Registro</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
            <div class="panel panel-primary">
                <p></p>
                <div class="panel-heading">Registro de presupuesto</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'PresupuestoController@store','class' => 'form-horizontal','id' => 'presupuestodetalle']) }}
                    @include('errors.validacion')
                    @include('presupuestos.detalle.formulario')
                    @include('presupuestos.tabla')
                    <input type="hidden" id="total" readonly>
                    <input type="hidden" name="contador" id="contador" readonly>
                    <div class="form-group">
                        <div class="col-md-6">
                            <button type="button" id="btnsubmit" class="btn btn-success">
                                <span class=""></span>    Guardar
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" id="btnlimpiar" class="btn btn-info">
                                <span class="fa fa-remove"></span>    Limpiar
                            </button>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('scripts')
{!! Html::script('js/presupuesto2.js') !!}
@endsection
