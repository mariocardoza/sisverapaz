@extends('layouts.app')
@section('migasdepan')
  @php
  $tipo_pago= ['1'=>'Planilla','2'=>'Por contrato'];
  $pago= ['1'=>'Mensual','2'=>'Quincenal','3'=>'Semanal'];
  @endphp
  <h1>
    Planilla
    <small>Detalles de planilla</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li class="active">Detalles de planilla</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <div class="btn-group pull-right">
            <a href="{{ url('/detalleplanillas/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
          </div>
        </div>

        <div class="box-body table-responsive">
          <table class="table table-striped table-bordered table-hover" id="example2">
            <thead>
              <th>Empleado</th>
              <th>Salario</th>
              <th>Forma de pago</th>
              <th>Tiempo de pago</th>
              <th>Acción</th>
              <?php $contador = 0 ?>
            </thead>
            <tbody>
              @foreach($empleados as $empleado)
                <tr>
                  <?php $contador++ ?>
                  <td>{{ $empleado->nombre }}</td>
                  <td>$ {{number_format($empleado->salario,2)}}</td>
                  <td>{{ $tipo_pago[$empleado->tipo_pago] }}</td>
                  <td>{{ $pago[$empleado->pago] }}</td>

                  <td>
                    <div class="btn-group">
                      <a href="{{ url('detalleplanillas/'.$empleado->elid)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                      <a href="{{ url('detalleplanillas/'.$empleado->elid.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
@endsection
