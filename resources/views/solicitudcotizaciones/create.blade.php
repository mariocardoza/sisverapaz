@extends('layouts.app')

@section('migasdepan')
    <h1>
        Solicitudes de cotizacion
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/solicitudcotizaciones') }}"><i class="fa fa-align-right"></i> Solicitudes</a></li>
        <li class="active">Registro</li>      </ol>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de solicitudes</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'SolicitudcotizacionController@store','class' => 'form-horizontal','id' => 'solicitudcotizacion']) }}
                    @include('solicitudcotizaciones.formulario')

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-1">
                            <button type="button" id="btnguardar" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk"></span>    Registrar
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
{!! Html::script('js/solicitudcotizaciones.js') !!}
@endsection
