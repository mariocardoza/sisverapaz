@extends('layouts.app')

@section('migasdepan')
<h1>
        Pagos por Bienes o Servicios
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado</li>
      </ol>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <p></p>
      <div class="box-header">
        <p></p>
        <div class="btn-group pull-left">
          <a href="javascript:void(0)" class="btn btn-primary active">Pagos</a>
          <a href="{{ url('pagos/ordencompras?estado=3') }}" class="btn btn-primary">Ordenes de Compra</a>
          <a href="{{ url('planillas') }}" class="btn btn-primary">Planilla</a>
        </div>
        <div class="btn-group pull-right">
          <a href="{{ url('/pagos?estado=1') }}" class="btn btn-danger">Pendientes</a>
          <a href="{{ url('/pagos?estado=3') }}" class="btn btn-primary">Pagados</a>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
            <th>N°</th>
            <th>Propietario</th>
            <th>N° Catastral/Inmueble</th>
            <th>Periodo</th>
            <th>Fecha Vencimiento</th>
            <th>Pago</th>
            <th>Estado</th>
          </thead>
          <tbody>
           
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
       <!-- /.box -->
  </div>
</div>
@endsection


@section("scripts")
<script>
  $(document).ready(function(e){
    
  });
</script>
@endsection