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
                <div class="panel-heading">Datos del catálogo</div>
                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <th>Nombre del catálogo</th>
                      <th>{{$catalogo->nombre}}</th>
                    </tr>
                    <tr>
                      <th>Unidad de medida</th>
                      <th>{{$catalogo->unidad_medida}}</th>
                    </tr>
                    <tr>
                      <th>Fecha de registro</th>
                      <th>{{fechaCastellano($catalogo->created_at)}}</th>
                    </tr>
                    
                  </table>
                      <a href="{{ url('catalogos/'.$catalogo->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
