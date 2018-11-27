@extends('layouts.app')
@section('migasdepan')
<h1>
        Bancos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de Bancos</li>
      </ol>
@endsection
@section('content')
<div class="row">
      <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                <div class="btn-group pull-right">
                    <a href="{{ url('/bancos/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
                    <a href="{{ url('/bancos?estado=1') }}" class="btn btn-primary">Activos</a>
                    <a href="{{ url('/bancos?estado=0') }}" class="btn btn-primary">Papelera</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>Id</th>
                  <th>Nombre del banco</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($bancos as $banco)
                  <tr>
                    <td>{{ $banco->id }}</td>
                    <td>{{ $banco->nombre}}</td>
                    <td>
                      @if($estado == 1 || $estado == "")
                        {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                        <a href="{{ url('bancos/'.$banco->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                        <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$banco->id.",'bancos')" }}><span class="glyphicon glyphicon-trash"></span></button>
                        {{ Form::close()}}
                      @else
                        {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                          <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$banco->id.",'bancos')" }}><span class="glyphicon glyphicon-trash"></span></button>
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
