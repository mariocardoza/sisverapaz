@extends('layouts.app')

@section('migasdepan')
<h1>
  Contribuyentes
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/contribuyentes') }}"><i class="fa fa-dashboard"></i>Contribuyentes</a></li>
  <li class="active">Listado de contribuyentes</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
    <div class="box-header">
      <h3 class="box-tittle">Listado</h3>
      <a href="{{ url('/contribuyentes/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span>Agregar</a>
      <a href="{{ url('/contribuyentes?estado=1') }}" class="btn btn-primary">Activos</a>
      <a href="{{ url('contribuyentes?estado=2') }}" class="btn btn-primary">Papelera</a>
    </div>

    <div class="box-body table-responsive">
      <table class="table table-striped table-bordered table-hover" id="example2">
        <thead>
          <th>Contribuyente</th>
          <th>Dirección</th>
          <th>DUI</th>
          <th>Teléfono</th>
          <th>Acción</th>
          <?php $contador = 0 ?>
        </thead>
      <tbody>
        @foreach($contribuyentes as $contribuyente)
        <tr>
          <?php $contador++ ?>
          <td>{{ $contribuyente->nombre }}</td>
          <td>{{ $contribuyente->direccion }}</td>
          <td>{{ $contribuyente->dui }}</td>
          <td>{{ $contribuyente->telefono }}</td>
          
          <td>
            @if($contribuyente->estado == 1)
            {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
            <a href="{{ url('contribuyentes/'.$contribuyente->id)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
            <a href="{{ url('contribuyentes/'.$contribuyente->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
            <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$contribuyente->id.",'contribuyentes')" }}><span class="glyphicon glyphicon-trash"></span></button>
            {{ Form::close()}}
            @else
            {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
            <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$contribuyente->id.",'contribuyentes')" }}><span class="glyphicon glyphicon-trash"></span></button>
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
  </div>
  </div>
</div>
@endsection