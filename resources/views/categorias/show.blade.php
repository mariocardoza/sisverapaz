@extends('layouts.app')

@section('migasdepan')
<h1>Ver datos del catálogo:</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/catalogos') }}"><i class="fa fa-industry"></i> Catálogos</a></li>
        <li class="active">Ver catálogo</li>
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
                      <th>Item</th>
                      <th>{{$categoria->item}}</th>
                    </tr>
                    <tr>
                      <th>Nombre del categoría</th>
                      <th>{{$categoria->nombre_categoria}}</th>
                    </tr>
                    <tr>
                      <th>Fecha de registro</th>
                      <th>{{fechaCastellano($categoria->created_at)}}</th>
                    </tr>
                    
                  </table>
                      <a href="{{ url('categorias/'.$categoria->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
