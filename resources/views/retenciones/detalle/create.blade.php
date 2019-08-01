@extends('layouts.app')

@section('migasdepan')
    <h1>
        Requisiciones
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
      <li><a href="{{ url('/requisiciones') }}"><i class="fa fa-balance-scale"></i> Requisiciones</a></li>
      <li class="active">Registro</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de presupuesto</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'RequisiciondetalleController@store','class' => 'form-horizontal','id' => 'requisicion']) }}
                    {!!Form::hidden('requisicion_id',$id)!!}
                    @include('requisiciones.detalle.formulario')
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-1">
                            <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk"></span>    Registrar
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
{!! Html::script('js/requisicion.js') !!}
@endsection
