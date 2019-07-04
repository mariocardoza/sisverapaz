@extends('layouts.app')
@section('migasdepan')
<h1>
        Tipos de préstamos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de tipos</li>
      </ol>
@endsection
@section('content')
<div class="row">
      <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                <div class="btn-group pull-right">
                    <a href="{{ url('/prestamotipos/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
                    <a href="{{ url('/prestamotipos?estado=1') }}" class="btn btn-primary">Activos</a>
                    <a href="{{ url('/prestamotipos?estado=0') }}" class="btn btn-primary">Papelera</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Nombre</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($tipos as $key => $tipo)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $tipo->nombre}}</td>
                    <td>
                      @if($tipo->estado == 1 || $estado == "")
                        {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                        <a href="{{ url('prestamotipos/'.$tipo->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                        <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$tipo->id.",'pretamotipos')" }}><span class="glyphicon glyphicon-trash"></span></button>
                        {{ Form::close()}}
                      @else
                        {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                          <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$tipo->id.",'pretamotipos')" }}><span class="glyphicon glyphicon-trash"></span></button>
                        {{ Form::close()}}
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
