<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SisVerapaz - Acta de recepción de bienes</title>
  <link type="text/css" media="all" rel="stylesheet" href="{{ asset('css/sisverapaz.css') }}">
  <style>
    
   
  </style>
</head>
<header>
    <div style="position: fixed; top: -100px;">
        <div class="row">
            <div class="col-xs-1">
                <img  src="{{asset('img/escudo.png')}}" width="80px" height="100px" alt="">
            </div>
            <div class="col-xs-9">
              
                <div class="row">
                  <div  class="text-center " style="color:#155CC2;font: 180% sans-serif;">ALCALDÍA MUNICIPAL DE VERAPAZ</div> 
                
                    <div class="text-center " style="font-size:13px;color:#155CC2;" >UNIDAD DE ADQUISICIONES Y CONTRATACIONES INSTITUCIONALES</div>
                
                    <div class="text-center " style="color:#155CC2;"> - UACI - </div >
                      <br>
                    <div style="border: 1px solid;" class="text-center">{{$tipo}}</div>
        
                </div>
      
            </div>
            <div class="col-xs-1">
                <img src="{{asset('img/escudoes.gif')}}" class="" width="80px" height="90px" alt="escudo El Salvador">
            </div>
          </div>
    </div>
</header>
<body>
<div>
  <div class="row">
      <br>
      <p style="font-size:14">Reunidos en: la <em> Alcaldía municipal de Verapaz, departamento de San Vicente;</em><b> a las: @if($orden->cotizacion->solicitudcotizacion->tipo==1) {{$orden->cotizacion->solicitudcotizacion->proyecto->fecha_acta->format('H:i a')}}
      del día: {{fechaCastellano($orden->cotizacion->solicitudcotizacion->proyecto->fecha_acta)}}</b></p>
      <p style="font-size:14"> Los señores: <b>{{$orden->cotizacion->proveedor->nombre}}</b> Ofertante y <b>{{Auth()->user()->empleado->nombre}}</b> Jefe de la unidad de adquisiciones y contrataciones institucionales.</p>
      @else {{$orden->cotizacion->solicitudcotizacion->requisicion->fecha_acta->format('H:i a')}}
        del día: {{fechaCastellano($orden->cotizacion->solicitudcotizacion->requisicion->fecha_acta)}}  .<p>
            <p style="font-size:14"> Los señores: <b>{{$orden->cotizacion->proveedor->nombre}}</b> Ofertante y <b>{{$orden->cotizacion->solicitudcotizacion->requisicion->user->empleado->nombre}}</b> Jefe de la {{$orden->cotizacion->solicitudcotizacion->requisicion->unidad->nombre_unidad}}.</p>
            @endif
          <p style="font-size:14">A efecto de constatar que lo que acontinuación de detalla, se entreta y recibe de acuerdoa lo establecido en la Orden de compra correspondiente:</p>
          <p style="font-size:14">
            <table class="table table-bordered"><thead>
              <tr>
                <th>Nombre</th>
                <th>Unidad de medida</th>
                <th>Cantidad</th>
              </tr>
          @foreach ($orden->cotizacion->solicitudcotizacion->detalle as $detalle)
              {{-- <b>{{$detalle->material->nombre}}@if(!$loop->last),@else. @endif</b> --}}
              <tr>
              <th>{{$detalle->material->nombre}}</th>
              <th>{{$detalle->material->unidadmedida->nombre_medida}}</th>
              <th>{{$detalle->cantidad}}</th>
              </tr>
              
          @endforeach
            </thead></table>
          </p>
          <p style="font-size:14">Dándonos por satisfechos ambas partes. Y en fe de lo cual firmamos la presente.</p>
          <br>
          <p><b>Entrega:</b></p>
          <p>Firma  __________________________________</p>
          <p>Nombre __________________________________</p>
          <br><br>
          <p class="text-right"><b>Recibí conforme:</b></p>
          <p class="text-right">Firma  ___________________</p>
          @if($orden->cotizacion->solicitudcotizacion->tipo==1)
          <p class="text-right">{{Auth()->user()->empleado->nombre}}</p>
          @else
        <p class="text-right">{{$orden->cotizacion->solicitudcotizacion->requisicion->user->empleado->nombre}}</p>
          @endif
  </div>
</div>
</body>
</html>

@extends('pdf.plantilla')
@section('reporte')
@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
<br>
  
@endsection