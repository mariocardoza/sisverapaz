@extends('layouts.app')

@section('migasdepan')
<h1>Ver datos del cargo:</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/cargos') }}"><i class="fa fa-industry"></i> Cargos</a></li>
        <li class="active">Ver cargo</li>
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
                      <th>{{$cargo->cargo}}</th>
                    </tr>
                    <tr>
                      <th>Fecha creación</th>
                      <th>{{fechaCastellano($cargo->created_at)}}</th>
                    </tr>
                    
                  </table>
                      <a href="{{ url('cargos/'.$cargo->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
