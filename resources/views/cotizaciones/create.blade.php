@extends('layouts.app')

@section('migasdepan')
      <h1>
        Cotización
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/solicitudcotizaciones/versolicitudes/'.$solicitud->presupuestosolicitud->presupuesto->proyecto->id) }}"><i class="fa fa-balance-scale"></i> Solicitud</a></li>
        <li class="active">Registro</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de cotizaciones</div>
                <div class="panel-body">
                    {{ Form::open(['action'=> 'CotizacionController@store', 'class' => 'form-horizontal']) }}
                    @include('cotizaciones.formulario')

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="button" id="btnguardar" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk">Registrar</span>
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
{{Html::script('js/cotizacion.js')}}
@endsection
