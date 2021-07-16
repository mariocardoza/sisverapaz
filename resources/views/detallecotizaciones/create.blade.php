@extends('layouts.app')

@section('migasdepan')
<h1>
        Detalles de Cotización
      </h1><p></p>
      <ol class="breadcrumb">
        <li><a href="{{ url('/detallecotizaciones') }}"><i class="fa fa-dashboard"></i> Detalles</a></li>
        <li class="active">Registro</li>      </ol>
@endsection

@section('content')
<p></p>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de detalles</div>
                <div class="panel-body">
                    {{ Form::open(['action'=> 'DetallecotizacionController@store', 'class' => 'form-horizontal']) }}
                    @include('detallecotizaciones.formulario')

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-success">
                                <span class="">Guardar</span>
                            </button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection