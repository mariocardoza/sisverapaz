@extends('layouts.app')

@section('migasdepan')
<h1>
        Ingresos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/ingresos') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Ingresos totales</li>
      </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"></h3>
              
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <div class="btn-group">
              <button class="btn btn-primary">Impuestos municipales</button>
              <button class="btn btn-primary">Partidas</button>
              <button class="btn btn-primary">Construcciones <span class="label label-danger">{{$construcciones}}</span></button>
              <button class="btn btn-primary">Otros</button>
            </div>
            <br><br>
            <table class="table table-striped table-bordered table-hover" id="example2">
              <thead>
                <th>N°</th>
                <th>Contribuyente</th>
                <th>Detalle</th>
                <th>Monto</th>
                <th>Fiestas</th>
                <th>Fecha</th>
                <th>Acción</th>
              </thead>
              <tbody>
                
              </tbody>
            </table>
              
            <div class="pull-right">

            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
</div>
</div>
@endsection