@extends('layouts.app')

@section('migasdepan')
    <h1>
        Requisiciones
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
      <li><a href="{{ url('/requisiciones') }}"><i class="fa fa-balance-scale"></i> Requisiciones</a></li>
      <li class="active">Registro</li>
      </ol>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de una nueva requisición</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'RequisicionController@store','class' => 'form-horizontal','id' => 'requisicion']) }}
                    @include('requisiciones.formulario')
                    <br>
                    <!--button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                      Agregar requisiciones
                    </button-->
                    <br>
                    
                    
                    <center><div class="form-group">
                        <div class="">
                            <button id="btnguardar" type="button" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk"></span>    Registrar
                            </button>
                        </div>
                    </div>
                    </center>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('scripts')
{!! Html::script('js/requisicion.js?cod='.date('Yidisus')) !!}
@endsection
