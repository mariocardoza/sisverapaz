@extends('layouts.app')

@section('migasdepan')
<h1>Ver datos del categoría:</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/categoriatrabajos') }}"><i class="fa fa-industry"></i> Categorías</a></li>
        <li class="active">Ver categoría</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Datos de la categoría</div>
                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <th>Categoría</th>
                      <th>{{$categoriatrabajo->nombre_categoria}}</th>
                    </tr>
                    <tr>
                      <th>Fecha creación</th>
                      <th>{{fechaCastellano($categoriatrabajo->created_at)}}</th>
                    </tr>
                    
                  </table>
                      <a href="{{ url('categoriatrabajos/'.$categoriatrabajo->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
