@extends('layouts.app')

@section('migasdepan')
  <h1>
    Pago a cuenta
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li><a href="{{ url('/planillaproyectos') }}"><i class="fa fa-money"></i> Planilla proyectos</a></li>
    <li class="active">pago a cuenta</li>
  </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Pago a cuenta periodo {{$catorcena->fecha_inicio->format("d/m/Y")}} al {{$catorcena->fecha_fin->format("d/m/Y")}}</div>
            <div class="panel-body">
                <table class="table" id="example2">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre completo</th>
                            <th>NIT</th>
                            <th>DUI</th>
                            <th>Dirección</th>
                            <th>Monto</th>
                            <th>Renta</th>
                            <th>Liquido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $index => $p)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$p->nombre}}</td>
                                <td>{{$p->nit}}</td>
                                <td>{{$p->dui}}</td>
                                <td>{{$p->direccion}}</td>
                                <td>${{number_format($p->pago,2)}}</td>
                                <td>${{number_format($p->renta,2)}}</td>
                                <td>${{number_format($p->liquido,2)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection