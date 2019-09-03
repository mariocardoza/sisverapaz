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
                  <th>Fuente de financiamiento</th>
                  <th>Responsable</th>
                  <th>Observaciones</th>
                  <th>Estado</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($requisiciones as $key => $requisicion)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $requisicion->codigo_requisicion }}</td>
                    <td>{{ $requisicion->actividad }}</td>
                    <td>{{ $requisicion->user->roleuser->role->description }}</td>
                    @if(isset($requisicion->cuenta_id))
                    <td>{{ $requisicion->cuenta->nombre}}</td>
                    @else 
                    <td>Sin definir</td>
                    @endif
                    <td>{{ $requisicion->user->empleado->nombre }}</td>
                    <td>{{ $requisicion->observaciones }}</td>
                    <td>{!! \App\requisicione::estado_ver($requisicion->id) !!}</td>
                    <td>
                      <div class="btn-group">
                        <a href="{{url('requisiciones/'.$requisicion->id)}}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span></a>
                      </div>
                    </td>
                  
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
