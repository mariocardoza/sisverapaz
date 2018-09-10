@extends('layouts.app')

@section('migasdepan')
<h1>Ver datos del fondo:</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/fondocats') }}"><i class="fa fa-industry"></i> Categorías</a></li>
        <li class="active">Ver información</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Datos del Fondo </div>
                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <th>Nombre de la categoría</th>
                      <th>{{$fondocat->categoria}}</th>
                    </tr>
                    <tr>
                      <th>Fecha de registro</th>
                      <th>{{fechaCastellano($fondocat->created_at)}}</th>
                    </tr>
                    
                  </table>
                      <a href="{{ url('fondocats/'.$fondocat->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
