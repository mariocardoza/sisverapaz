@extends('layouts.app')

@section('migasdepan')
  <h1>
   Ordenes de compras
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/ordencompras') }}"><i class="fa fa-dashboard"></i> Ordenes de compra</a></li>
    <li class="active">Ver listado</li>
  </ol>
@endsection

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-11">
              <div class="panel panel-primary">
                  <div class="panel-heading">Orden de compra </div>
                  <div class="panel-body">
                    <div class="pull-right">
                      <a title="Imprimir orden de compra" href="{{url('reportesuaci/ordencompra/'.$orden->id)}}" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
                    </div>
                    <hr>
                      <table width="100%" border="1" rules="groups">
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <tbody>
                          <tr>
                            <td>Señores: </td>
                            <td>Orden N°: <b>{{$orden->numero_orden}}</b> </td>
                          </tr>
                          <tr>
                            <td><b>{{$orden->cotizacion->proveedor->nombre}}</b></td>
                            @if($orden->cotizacion->solicitudcotizacion->tipo==1)
                            <td>Solicitud N°: <b>{{$orden->cotizacion->solicitudcotizacion->presupuestosolicitud->solicitudcotizacion->numero_solicitud}}</b></td>
                          @elseif($orden->cotizacion->solicitudcotizacion->tipo==2)
                            <td>requisición N°: <b>{{$orden->cotizacion->solicitudcotizacion->requisicion->codigo_requisicion}}</b></td>
                          @endif
                          </tr>
                          <tr>
                            <td>NIT:</td>
                            <td>Fecha: <b>{{$orden->created_at->format('d-m-Y')}}</b> </td>
                          </tr>
                          <tr>
                            <td><b>{{$orden->cotizacion->proveedor->nit}}</b></td>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>
                      <br>
                      <div class="table-responsive">
                        <table width="100%" border="1" rules="all">
                          <thead>
                            <tr>
                              <th width="5%">N°</th>
                              <th width="50%">DESCRIPCIÓN</th>
                              <th width="10%">UNIDAD DE MEDIDA</th>
                              <th width="10%">CANTIDAD</th>
                              <th width="10%">PRECIO UNITARIO</th>
                              <th width="15%">SUBTOTAL</th>
                              @php
                                $total=0.0;
                              @endphp
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($orden->cotizacion->detallecotizacion as $key => $detalle)
                              <tr>
                                @php
                                  $total=$total+$detalle->precio_unitario*$detalle->cantidad;
                                @endphp
                                <td><center>{{$key+1}}</center></td>
                                <td>{{$detalle->descripcion}}</td>
                                <td><center>{{$detalle->unidad_medida}}</center> </td>
                                <td><center>{{$detalle->cantidad}}</center></td>
                                <td><p align="right">${{number_format($detalle->precio_unitario,2)}}</p> </td>
                                <td><p align="right">${{number_format($detalle->precio_unitario*$detalle->cantidad,2)}}</p> </td>
                              </tr>
                            @endforeach
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="6"></td>
                            </tr>
                            <tr>
                              <td colspan="5">Total en letras: <b>{{numaletras($total)}}</b></td>
                              <th><p align="right">${{number_format($total,2)}}</p></th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                      <br>
                      <br>

                      <table class="table">
                        <tbody>
                          <tr>
                            <th>Observaciones</th>
                            <td>{{$orden->observaciones}}</td>
                          </tr>
                          <tr>
                            <th>Lugar de entrega</th>
                            <td>{{$orden->direccion_entrega}}</td>
                          </tr>
                          <tr>
                            <th>Condición de pago</th>
                            <td>{{$orden->cotizacion->solicitudcotizacion->formapago->nombre}}</td>
                          </tr>
                          <tr>
                            <th width="40%">Fuente de financiamiento</th>
                            <td width="60%">
                              @if($orden->cotizacion->solicitudcotizacion->tipo==1)
                                @foreach($orden->cotizacion->solicitudcotizacion->presupuestosolicitud->presupuesto->proyecto->fondo as $fondos)
                                  {{$fondos->fondocat->categoria}} /
                                @endforeach
                                {{$orden->cotizacion->solicitudcotizacion->presupuestosolicitud->presupuesto->proyecto->nombre}}
                            @elseif ($orden->cotizacion->solicitudcotizacion->tipo==2)
                              {{$orden->cotizacion->solicitudcotizacion->requisicion->fondocat->categoria}}
                            @endif
                            </td>
                          </tr>
                          <tr>
                            <th>Fecha de entrega</th>
                            <td>
                              @if($orden->fecha_fin == "")
                              {{fechaCastellano($orden->fecha_inicio)}}
                            @else
                              del {{fechaCastellano($orden->fecha_inicio)}} al {{fechaCastellano($orden->fecha_fin)}}
                            @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection
