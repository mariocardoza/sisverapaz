@extends('layouts.app')

@section('migasdepan')
<h1>
  Cuentas
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
  <li><a href="{{ url('/cuentas') }}"><i class="fa fa-dashboard"></i>Cuentas</a></li>
  <li class="active">Información de la cuenta</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary">
        <div class="panel-heading">Movimientos de la cuenta {{$cuenta->nombre}}</div>
        <div class="panel-body" style="padding:3em;">
            <table class="table" id="example2">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th  width="50%">Detalle</th>
                        <th >Fecha</th>
                        <th >Hora</th>
                        <th class="text-right">Ingreso</th>
                        <th class="text-right">Egreso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cuenta->cuentadetalle as $index => $detalle)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td >{{$detalle->accion}}</td>
                        <td >{{$detalle->created_at->format('d/m/Y')}}</td>
                        <td >{{$detalle->created_at->format('g:i a')}}</td>
                        @if($detalle->tipo==1)
                        <td class="text-right">${{number_format($detalle->monto,2)}}</td>
                        <td class="text-center">-</td>
                        @else
                        <td class="text-center">-</td>
                        <td class="text-right">${{number_format($detalle->monto,2)}}</td>
                        @endif
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                
                <div class="col-xs-12"><hr></div>
                <div class="col-xs-10"><b>Disponible</b> &nbsp; </div>
                <div class="col-xs-2 text-right"><b>${{number_format(\App\CuentaDetalle::total_cuenta($cuenta->id),2)}}</b></div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection