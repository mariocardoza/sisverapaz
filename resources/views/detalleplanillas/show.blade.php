@extends('layouts.app')

@section('migasdepan')
  @php
  $tipo_pago= ['1'=>'Planilla','2'=>'Temporal'];
  $pago= ['1'=>'Mensual','2'=>'Quincenal','3'=>'Semanal'];
  @endphp
<h1>
  Ver Detalle de Planilla:
        <small><b>{{ $detalle->empleado->nombre }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/detalleplanillas') }}"><i class="fa fa-user-circle-o"></i> Detalle Planilla</a></li>
        <li class="active">Ver detalle</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Detalles de planilla </div>
                <div class="panel-body">
                  <div class="form-group">
                      <label for="nombree" class="col-md-4 control-label">Nombre del Empleado: </label>
                      <label for="nombree" class="col-md-4 control-label">{{$detalle->empleado->nombre}}</label>
                  </div><br>
                  <div class="form-group">
                    <label for="nombree" class="col-md-4 control-label">Cargo:</label>
                    <label for="nombree" class="col-md-4 control-label">
                        @if($detalle->cargo)
                        {{$detalle->cargo}}
                        @else
                        Cargo no asignado
                        @endif
                    </label>
                  </div><br>                      
                  <div class="form-group">
                      <label for="nombree" class="col-md-4 control-label">Salario: </label>
                      <label for="nombree" class="col-md-4 control-label">$ {{number_format($detalle->salario,2)}}</label>
                  </div><br>
                  <div class="form-group">
                      <label for="nombree" class="col-md-4 control-label">Forma de pago: </label>
                      <label for="nombree" class="col-md-4 control-label">{{$tipo_pago[$detalle->tipo_pago]}}</label>
                  </div><br>
                  <div class="form-group">
                      <label for="nombree" class="col-md-4 control-label">Tiempo de pago: </label>
                      <label for="nombree" class="col-md-4 control-label">{{$pago[$detalle->pago]}}</label>
                  </div><br>
                  <div class="form-group">
                      <label for="nombree" class="col-md-4 control-label">Fecha de inicio de labores: </label>
                      <label for="nombree" class="col-md-4 control-label">
                          @if($detalle->fecha_inicio!="")
                          {{$detalle->fecha_inicio->format("d/m/Y")}}
                          @else
                          Fecha no registrada
                          @endif
                      </label>
                  </div><br>
                  <form class="form-horizontal">
                    <a href="{{ url('/detalleplanillas/'.$detalle->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span> Editar</a>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
