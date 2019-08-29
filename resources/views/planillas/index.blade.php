@extends('layouts.app')
@section('migasdepan')
  <h1>
    Planilla
    <small>Control de planilla</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li class="active">Control de planilla</li>
  </ol>
@endsection
@php
$tipo_pago= ['1'=>'Planilla mensual','2'=>'Planilla quincenal'];
@endphp
@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Listado</h3>
            <a href="{{ url('/planillas/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
        </div>

        <div class="box-body table-responsive">
          <table class="table table-striped table-bordered table-hover" id="example2">
            <thead>
              <th>Fecha </th>
              <th>Tipo pago</th>
              <th>Acción</th>
              <?php $contador = 0 ?>
            </thead>
            <tbody>
              @foreach($planillas as $planilla)
                <tr>
                  @php
                      $dato= explode("-",$planilla->fecha);
                  @endphp
                    <td>{{$dato[2]."-".$dato[1]."-".$dato[0]}}</td>
                    <td>{{$tipo_pago[$planilla->tipo_pago]}}</td>
                  <td>
                    <div class="btn-group">
                      <a href="{{ url('planillas/'.$planilla->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                      <a href="{{ url('reportestesoreria/planillas/'.$planilla->id) }}" class="btn btn-success btn-xs" target="_blank"><span class="glyphicon glyphicon-list"></span></a>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="pull-right">

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
