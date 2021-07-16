@extends('layouts.app')
@section('migasdepan')
<h1>
        Préstamos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de Préstamos</li>
      </ol>
@endsection
@section('content')
<div class="row">
      <div class="col-xs-12">
          <div class="box">
            <p></p>
            <div class="box-header">
              <p></p>
              <div class="btn-group pull-right">
                <a href="{{ url('/prestamos/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
                <a href="{{ url('/prestamos?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/prestamos?estado=2') }}" class="btn btn-primary">Papelera</a>
            </div>
          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>Id</th>
                  <th>Nombre del empleado</th>
                  <th>Banco</th>
                  <th>Número de cuenta</th>
                  <th>Monto</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($prestamos as $prestamo)
                  <tr>
                    <td>{{ $prestamo->id }}</td>
                    <td>{{ $prestamo->empleado->nombre }}</td>
                    <td>{{ $prestamo->banco->nombre }}</td>
                    <td>{{ $prestamo->numero_de_cuenta }}</td>
                    <td>$ {{ number_format($prestamo->monto,2)}}</td>
                    <td>
                      <a href="{{ url('prestamos/'.$prestamo->id) }}" class="btn btn-primary"><span class="fa fa-eye"></span></a>
                      @if($estado == 1 || $estado == "")
                          <a href="{{ url('prestamos/'.$prestamo->id.'/edit') }}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                      @endif
                    </td>
                  </tr>
                  @endforeach
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
