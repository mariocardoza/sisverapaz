@extends('layouts.app')

@section('migasdepan')
  <h1>
    Pago a cuenta
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li class="active">pago a cuenta</li>
  </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Pago a cuenta</div>
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
                                <th>{{$index+1}}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection