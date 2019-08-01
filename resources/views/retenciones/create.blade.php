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
                <div class="panel-heading">Registro de presupuesto</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'RequisicionController@store','class' => 'form-horizontal','id' => 'requisicion']) }}
                    @include('requisiciones.formulario')
                    <br>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                      Agregar requisiciones
                    </button>
                    <br>
                    @include('requisiciones.tabla')
                    <input type="hidden" name="contador" id="contador" readonly>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-1">
                            <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk"></span>    Registrar
                            </button>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Necesidad de la requisicion</h4>
                      </div>
                      <div class="modal-body">
                        @include('requisiciones.detalle.formulario')
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="agregar" data-dismiss="modal" class="btn btn-success">Agregar</button>
                      </div>
                    </div>
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
