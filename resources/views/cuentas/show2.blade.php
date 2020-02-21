@extends('layouts.app')

@section('migasdepan')
<h1>
    &nbsp
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i>Inicio</a></li>
  <li><a href="{{ url('/cuentas/proyectos') }}"><i class="fa fa-money"></i>Cuentas de proyectos</a></li>
  <li class="active">Información de la cuenta</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary">
        <div class="panel-heading">Movimientos de la cuenta del proyecto <b>{{$cuenta->proyecto->nombre}}</b></div>
        <div class="panel">
            <div class="row">
                <div class="col-xs-1"><b>N°</b></div>
                <div class="col-xs-3"><b>Detalle</b></div>
                <div class="col-xs-2"><b>N° acuerdo</b></div>
                <div class="col-xs-2"><b>Fecha</b></div>
                <div class="col-xs-2"><b>Hora</b></div>
                <div class="col-xs-2 text-right"><b>Monto</b></div>
                <div class="col-xs-12"><hr></div>
                @foreach ($cuenta->cuentadetalle as $index => $detalle)
                    <div class="col-xs-1">{{$index+1}}</div> 
                    <div class="col-xs-3">{{$detalle->accion}}</div> 
                    <div class="col-xs-2">{{$detalle->acuerdo}}</div> 
                    <div class="col-xs-2">{{$detalle->created_at->format('d/m/Y')}}</div> 
                    <div class="col-xs-2">{{$detalle->created_at->format('g:i a')}}</div>
                    <div class="col-xs-2 text-right">${{number_format($detalle->monto,2)}}</div>
                    <div class="col-xs-12"><hr></div>  
                @endforeach
                <div class="col-xs-12"><hr></div>
                <div class="col-xs-10">Disponible &nbsp; </div>
                <div class="col-xs-2 text-right"><b>${{number_format(\App\CuentaproyDetalle::total_cuenta($cuenta->id),2)}}</b></div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection