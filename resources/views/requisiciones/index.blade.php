@extends('layouts.app')

@section('migasdepan')
<h1>
        Requisiciones
        <small>Control de requisiciones</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de requisiciones</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
              <div class="btn-group pull-right">
                <a href="{{ url('/requisiciones/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                <a href="{{ url('/requisiciones?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/requisiciones?estado=2') }}" class="btn btn-primary">Papelera</a>
              </div>
          </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Código</th>
                  <th>Actividad</th>
                  <th>Unidad administrativa</th>
                  <th>Responsable</th>
                  <th>Observaciones</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @foreach($requisiciones as $key => $requisicion)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{$requisicion->codigo_requisicion }}</td>
                    <td>{{ $requisicion->actividad }}</td>
                    <td>{{ $requisicion->user->id }}</td>
                    <td>{{ $requisicion->user->empleado->nombre }}</td>
                    <td>{{ $requisicion->observaciones }}</td>
                    @if($requisicion->estado == 1)
                    <td><span class="label-primary">En espera</span></td>
                    <td>
                      <div class="btn-group">
                        <a href="{{url('requisiciones/'.$requisicion->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                        <a href="{{url('requisiciones/'.$requisicion->id.'/edit')}}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                        <a href="{{url('requisiciones/'.$requisicion->id.'/edit')}}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
                      </div>
                    </td>
                  @elseif($requisicion->estado == 2)
                      <td><span class="label-danger">Rechazada</span></td>
                      <td>
                        <div class="btn-group">
                          <a href="{{url('requisiciones/'.$requisicion->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                          <a href="{{url('requisiciones/'.$requisicion->id.'/edit')}}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                        </div>
                      </td>
                    @elseif( $requisicion->estado == 3)
                      <td><span class="label-warning">Aprobado</span></td>
                      <td>
                        <div class="btn-group">
                          <a href="{{url('requisiciones/'.$requisicion->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                        </div>
                      </td>
                    @elseif ( $requisicion->estado == 4)
                      <td><span class="label-success">Espera de orden de compra</span></td>
                      <td>
                        <div class="btn-group">
                          <a href="{{url('requisiciones/'.$requisicion->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                        </div>
                      </td>
                    @elseif( $requisicion->estado == 5)
                      <td><span class="label-success">Espera de recibir suministros</span></td>
                      <td>
                        <div class="btn-group">
                          <a href="{{url('requisiciones/'.$requisicion->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                          <a href="{{url('ordencompras/create/'.$requisicion->id)}}" class="btn btn-success btn-xs"><span class="fa fa-file-pdf-o"></span></a>
                        </div>
                      </td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
</div>
@endsection
