@extends('layouts.app')

@section('migasdepan')
      <h1>
        <small>Ver cotizacion <b>{{ $cotizacion->nombre }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/cotizaciones')}}"><i class="fa fa-balance-scale"></i> Cotizaciones</a></li>
        <li class="active">Ver</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Datos de la Cotización </div>
                <div class="panel-body">
                  <table class="table">
                    <tr>
                      <th>Nombre del proyecto o actividad</th>
                      @if($cotizacion->solicitudcotizacion->tipo==1)
                      <th>{{$cotizacion->solicitudcotizacion->presupuestosolicitud->presupuesto->proyecto->nombre}}</th>
                    @elseif($cotizacion->solicitudcotizacion->tipo==2)
                      <th>{{$cotizacion->solicitudcotizacion->requisicion->actividad}}</th>
                    @endif
                    </tr>
                    <tr>
                      <th>Nombre del proveedor</th>
                      <th>{{$cotizacion->proveedor->nombre}}</th>
                    </tr>
                    <tr>
                      <th>Forma de pago</th>
                      <th>{{$cotizacion->descripcion}}</th>
                    </tr>
                    <tr>
                      <th>Validez de la oferta</th>
                      <th></th>
                    </tr>
                    <tr>
                      <th>Plazo de entrega</th>
                      <th></th>
                    </tr>
                  </table>
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                              <tr>
                                <th width="40%">MATERIAL</th>
                                <th width="10%">MARCA</th>
                                <th width="15%">CANTIDAD</th>
                                <th width="20%">UNIDAD DE MEDIDA</th>
                                <th width="15%">PRECIO</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($cotizacion->detallecotizacion as $detalle)
                              <tr>
                                <td>{{strtoupper($detalle->descripcion)}}</td>
                                <td>{{$detalle->marca}}</td>
                                <td>{{$detalle->cantidad}}</td>
                                <td>{{strtoupper($detalle->unidad_medida)}}</td>
                                <td>${{number_format($detalle->precio_unitario,2)}}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
